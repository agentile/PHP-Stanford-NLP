<?php
/**
 * PHP interface for Stanford Parser
 * http://nlp.stanford.edu/software/lex-parser.shtml
 *
 *
 * @link https://github.com/agentile/PHP-Stanford-NLP
 * @version 0.1.0
 * @author Anthony Gentile <asgentile@gmail.com>
 */
namespace StanfordNLP;

class Parser extends Base {

    /**
     * Output format?
     *
     * CSV style list of output types
     * e.g. penn,typedDependencies,wordsAndTags
     */
    public $output_format = "wordsAndTags,penn,typedDependencies";

    /**
     * Use lexicalized parser?
     */
    public $lexicalized_parser = false;

    /**
     * Constructor!
     *
     * @param $model string path to tagging model file
     * @param $jar string path stanford parser jar file
     * @param $java_options mixed command line arguments to pass
     *
     * @return null
     */
    public function __construct($jar, $models_jar = null, $java_options = array('-mx300m'))
    {
        parent::__construct();
        $this->setJar($jar);
        $this->setModelsJar($models_jar);
        $this->setJavaOptions($java_options);
    }

    /**
     * Parse sentence
     *
     * @param $tokens array tokens
     *
     * @return mixed
     */
    public function parseSentence($sentence)
    {
        $results = $this->parseSentences(array($sentence));
        return isset($results[0]) ? $results[0] : array();
    }

    /**
     * Parse array of sentences
     *
     * @param $sentences array of sentences
     *
     * @return mixed
     */
    public function parseSentences($sentences)
    {
        // Reset errors and output
        $this->setErrors(null);
        $this->setOutput(null);

        // Make temp file to store sentences.
        $tmpfname = tempnam(DIRECTORY_SEPARATOR . 'tmp', 'phpnlpparser');
        chmod($tmpfname, 0644);
        $handle = fopen($tmpfname, "w");

        $str = implode("\n", $sentences);

        fwrite($handle, $str);
        fclose($handle);

        // Create process to run stanford ner.
        $descriptorspec = array(
           0 => array("pipe", "r"),  // stdin
           1 => array("pipe", "w"),  // stdout
           2 => array("pipe", "w")   // stderr
        );

        $options = implode(' ', $this->getJavaOptions());

        $parser = $this->lexicalized_parser ? 'edu/stanford/nlp/models/lexparser/englishFactored.ser.gz' : 'edu/stanford/nlp/models/lexparser/englishPCFG.ser.gz';
        $osSeparator = $this->php_os == 'windows' ? ';' : ':';
        $cmd = $this->getJavaPath()
            . " $options -cp \""
            . $this->getJar()
            . $osSeparator
            . $this->getModelsJar()
            . '" edu.stanford.nlp.parser.lexparser.LexicalizedParser -encoding UTF-8 -outputFormat "'
            . $this->getOutputFormat()
            . "\" "
            . $parser
            . " "
            . $tmpfname;


        $process = proc_open($cmd, $descriptorspec, $pipes, dirname($this->getJar()));

        $output = null;
        $errors = null;
        if (is_resource($process)) {
            // We aren't working with stdin
            fclose($pipes[0]);

            // Get output
            $output = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            // Get any errors
            $errors = stream_get_contents($pipes[2]);
            fclose($pipes[2]);

            // close pipe before calling proc_close in order to avoid a deadlock
            $return_value = proc_close($process);
            if ($return_value == -1) {
                throw new Exception("Java process returned with an error (proc_close).");
            }
        }

        unlink($tmpfname);

        if ($errors) {
            $this->setErrors($errors);
        }

        if ($output) {
            $this->setOutput($output);
        }

        return $this->parseOutput();
    }

    /**
     * Build text output from jar into array structure
     *
     * @return array
     */
    public function parseOutput()
    {
        // Output is separated by two line breaks
        // Word and tags is first
        // penn is second
        // typed dependencies is last.
        $output = explode("\n\n", trim($this->getOutput()));

        $formats = explode(',', $this->getOutputFormat());
        foreach ($formats as $k => $v) {
            $formats[$k] = trim(strtolower($v));
        }

        $count = count($formats);
        $length = count($output);
        $i = 0;
        $set = array();

        while ($i < $length) {
            $arr = array(
                'wordsAndTags' => null,
                'penn' => null,
                'typedDependencies' => null,
            );
            $index_offset = 0;
            if (in_array('wordsandtags', $formats)) {
                $arr['wordsAndTags'] = $this->parseWordsAndTags($output[$i+$index_offset]);
                $index_offset++;
            }

            if (in_array('penn', $formats)) {
                $arr['penn'] = $this->parsePenn($output[$i+$index_offset]);
                $index_offset++;
            }

            if (in_array('typeddependencies', $formats)) {
                $arr['typedDependencies'] = $this->parseTypedDependencies($output[$i+$index_offset]);
            }
            $set[] = $arr;
            $i += $count;
        }

        return $set;
    }

    /**
     * POS tags into array structure
     *
     * @return array
     */
    public function parseWordsAndTags($str)
    {
        $arr = array();

        if (trim($str) == '') {
            return $arr;
        }
        $s = array();
        $tagged = explode(' ', trim($str));
        foreach ($tagged as $tag) {
            $parts = explode('/', $tag);
            $pos = array_pop($parts);
            $arr[] = array(implode('/', $parts), $pos);
        }

        return $arr;
    }

    /**
     * Penn into array structure
     *
     * @return array
     */
    public function parsePenn($string)
    {
        $arr = array('parent' => null, 'children' => array());
        $stack = array();
        $length = strlen($string);
        $node = '';
        $bracket = 1;
        for ($i = 1; $i < $length; $i++) {
            if ($string[$i] == '(') {
                $bracket += 1;
                $match_i = $this->getMatchingParen($string, $i);
                $arr['children'][] = $this->parsePenn(substr($string, $i, ($match_i - $i) + 1));
                $i = $match_i - 1;
            } else if ($string[$i] == ')') {
                $bracket -= 1;
                $arr['parent'] = trim($node);
            } else {
                $node .= $string[$i];
            }
            if ($bracket == 0) {
                return $arr;
            }
        }

        return $arr;
    }

    /**
     * Find the position of a matching closing bracket for a string opening bracket
     */
    public function getMatchingParen($string, $start_pos)
    {
        $length = strlen($string);
        $bracket = 1;
        foreach (range($start_pos + 1, $length) as $i) {
            if ($string[$i] == '(') {
                $bracket += 1;
            } else if ($string[$i] == ')') {
                $bracket -= 1;
            }
            if ($bracket == 0) {
                return $i;
            }
        }
    }

    /**
     * Typed dependencies into array structure
     *
     * @return array
     */
    public function parseTypedDependencies($str)
    {
        $arr = array();
        $lines = explode("\n", $str);
        foreach ($lines as $line) {
            $paren_pos = strpos($line, '(');

            if ($paren_pos === false) {
                continue;
            }

            $type = substr($line, 0, $paren_pos);
            $parts = explode(', ', substr($line, $paren_pos + 1, -1));

            $first = substr($parts[0], 0, strrpos($parts[0], '-'));
            $first_index = (int) substr($parts[0], strrpos($parts[0], '-') + 1);

            $second = substr($parts[1], 0, strrpos($parts[1], '-'));
            $second_index = (int) substr($parts[1], strrpos($parts[1], '-') + 1);

            $arr[] = array(
                'type' => $type,
                array(
                    'feature' => $first,
                    'index' => $first_index
                ),
                array(
                    'feature' => $second,
                    'index' => $second_index
                )
            );
        }
        return $arr;
    }

    /**
     * Lexicalized parser setter
     *
     * @param $bool
     *
     * @return null
     */
    public function setLexicalizedParser($bool)
    {
        $this->lexicalized_parser = (bool) $bool;
    }

    /**
     * Lexicalized parser getter
     *
     * @return boolean
     */
    public function getLexicalizedParser()
    {
        return $this->lexicalized_parser;
    }

    /**
     * Output format setter
     *
     * @param $format string
     *
     * @return null
     */
    public function setOutputFormat($format)
    {
        $this->output_format = $format;
    }

    /**
     * Output format getter
     *
     * @return mixed
     */
    public function getOutputFormat()
    {
        return $this->output_format;
    }
}
