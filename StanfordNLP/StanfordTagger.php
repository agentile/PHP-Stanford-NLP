<?php
/**
 * PHP interface for Stanford Taggers (NER, POS Tagger)
 * e.g. http://nlp.stanford.edu/downloads/tagger.shtml
 *
 * Mimicks http://nltk.org/_modules/nltk/tag/stanford.html#StanfordTagger
 *
 *
 * @link https://github.com/agentile/PHP-Stanford-NLP
 * @version 0.1.0
 * @author Anthony Gentile <asgentile@gmail.com>
 */
namespace StanfordNLP;

class StanfordTagger extends Base {

    /**
     * Tag separator
     */
    protected $separator = '_';

    /**
     * Tag type
     */
    protected $tag_type = 'pos';

    /**
     * Constructor!
     *
     * @return null
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Separator setter
     *
     * @param $output
     *
     * @return null
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;
    }

    /**
     * Separator getter
     *
     * @return mixed
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * Tag type setter
     *
     * @param $type
     *
     * @return null
     */
    public function setTagType($type)
    {
        $this->tag_type = $type;
    }

    /**
     * Tag type getter
     *
     * @return mixed
     */
    public function getTagType()
    {
        return $this->tag_type;
    }

    /**
     * Tag from an array of tokens for a sentence
     *
     * @param $tokens array tokens
     *
     * @return mixed
     */
    public function tag($tokens)
    {
        $results = $this->batchTag(array($tokens));
        return isset($results[0]) ? $results[0] : array();
    }

    /**
     * Tag multiple arrays of tokens for sentences
     *
     * @param $sentences array array of arrays of tokens
     *
     * @return mixed
     */
    public function batchTag($sentences)
    {
        // Reset errors and output
        $this->setErrors(null);
        $this->setOutput(null);

        // Make temp file to store sentences.
        $tmpfname = tempnam(DIRECTORY_SEPARATOR . 'tmp', 'phpnlptag');
        chmod($tmpfname, 0644);
        $handle = fopen($tmpfname, "w");

        foreach ($sentences as $k => $v) {
            $sentences[$k] = implode(' ', $v);
        }
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
        $osSeparator = $this->php_os == 'windows' ? ';' : ':';
        switch ($this->getTagType()) {
            case 'pos':
                $separator = $this->getSeparator();
                $cmd = escapeshellcmd(
                    $this->getJavaPath()
                    . " $options -cp \""
                    . $this->getJar()
                    . "{$osSeparator}\" edu.stanford.nlp.tagger.maxent.MaxentTagger -model "
                    . $this->getModel()
                    . " -textFile "
                    . $tmpfname
                    . " -outputFormat slashTags -tagSeparator "
                    . $separator
                    . " -encoding utf8"
                );
            break;
            case 'ner':
                $cmd = escapeshellcmd(
                    $this->getJavaPath()
                    . " $options -cp \""
                    . $this->getJar()
                    . "{$osSeparator}\" edu.stanford.nlp.ie.crf.CRFClassifier -loadClassifier "
                    . $this->getClassifier()
                    . " -textFile "
                    . $tmpfname
                    . " -encoding utf8"
                );
            break;
        }

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
        $output = $this->getOutput();
        if (!$output) {
            return array();
        }

        $separator = $this->getSeparator();
        $arr = array();
        $sentences = explode("\n", $output);
        foreach ($sentences as $sentence) {
            if (trim($sentence) == '') {
                continue;
            }
            $s = array();
            $tagged = explode(' ', trim($sentence));
            foreach ($tagged as $tag) {
                $parts = explode($separator, $tag);
                $pos = array_pop($parts);
                $s[] = array(implode($separator, $parts), $pos);
            }
            $arr[] = $s;
        }
        return $arr;
    }
}
