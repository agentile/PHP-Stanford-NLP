<?php
/**
 * PHP interface for Stanford POS Tagger
 * http://nlp.stanford.edu/downloads/tagger.shtml
 * 
 * Mimicks http://nltk.org/_modules/nltk/tag/stanford.html#StanfordTagger
 * 
 * 
 * @link https://github.com/agentile/PHP-Stanford-POS-Tagger
 * @version 0.1.0
 * @author Anthony Gentile <asgentile@gmail.com>
 */
namespace StanfordNLP;

class POSTagger {

    /**
     * Java path
     * 
     * relative/absolute path to java 
     * e.g. /usr/bin/java
     */
    protected $java_path = 'java';
    
    /**
     * Stanford POS Tagger jar file
     */
    protected $jar;
    
    /**
     * Tagger model file
     */
    protected $model;
    
    /**
     * Java options to use with our jar instance
     */
    protected $java_options;
    
    /**
     * Output from POS Tagger
     */
    protected $output = null;
    
    /**
     * Errors from POS Tagger
     */
    protected $errors = null;
    
    /**
     * POS Tag separator
     */
    protected $separator = '_';
    
    /**
     * Constructor!
     * 
     * @param $model string path to tagging model file
     * @param $jar string path stanford pos tagger jar file
     * @param $java_options mixed command line arguments to pass
     * 
     * @return null
     */
    public function __construct($model, $jar, $java_options = array('-mx300m'))
    {
        $this->setModel($model);
        $this->setJar($jar);
        $this->setJavaOptions($java_options);
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
        $tmpfname = tempnam(DIRECTORY_SEPARATOR . 'tmp', 'phppostagger');
        chmod($tmpfname, 0644);
        $handle = fopen($tmpfname, "w");

        foreach ($sentences as $k => $v) {
            $sentences[$k] = implode(' ', $v);
        }
        $str = implode("\n", $sentences);
        
        fwrite($handle, $str);
        fclose($handle);
        
        // Create process to run stanford pos tagger.
        $descriptorspec = array(
           0 => array("pipe", "r"),  // stdin 
           1 => array("pipe", "w"),  // stdout 
           2 => array("pipe", "w")   // stderr 
        );
        
        $options = implode(' ', $this->getJavaOptions());
        $separator = $this->getSeparator();
        $cmd = escapeshellcmd($this->getJavaPath() . " $options -cp '" . $this->getJar() 
            . ":' edu.stanford.nlp.tagger.maxent.MaxentTagger -model ". $this->getModel() 
            ." -textFile ".$tmpfname." -outputFormat slashTags -tagSeparator ".$separator." -encoding utf8");
            
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
                throw new \StanfordNLP\Exception("Java process returned with an error (proc_close).");
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
     * Output setter
     *
     * @param $output
     *
     * @return null
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }
    
    /**
     * Output getter
     *
     * @return mixed
     */
    public function getOutput()
    {
        return $this->output;
    }
    
    /**
     * Errors setter
     *
     * @param $errors 
     *
     * @return null
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }
    
    /**
     * Errors getter
     *
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }
    
    /**
     * Java path setter
     *
     * @param $java_path string path to java executable
     *
     * @return null
     */
    public function setJavaPath($java_path)
    {
        $this->java_path = $java_path;
    }
    
    /**
     * Java path getter
     *
     * @return string
     */
    public function getJavaPath()
    {
        return $this->java_path;
    }

    /**
     * Model setter
     *
     * @param $model string path to model file
     *
     * @return null
     */
    public function setModel($model)
    {
        if (file_exists($model)) {
            $this->model = $model;
        } else {
            throw new \StanfordNLP\Exception("Model file path does not exist.");
        }
    }
    
    /**
     * Model getter
     *
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }
    
    /**
     * Jar setter
     *
     * @param $jar string path to jar file
     *
     * @return null
     */
    public function setJar($jar)
    {
        if (file_exists($jar)) {
            $this->jar = $jar;
        } else {
            throw new \StanfordNLP\Exception("Jar file path does not exist.");
        }
    }
    
    /**
     * Jar getter
     *
     * @return mixed
     */
    public function getJar()
    {
        return $this->jar;
    }
    
    /**
     * Java options setter
     *
     * @param $options mixed java options
     *
     * @return null
     */
    public function setJavaOptions($options)
    {
        $this->java_options = (array) $options;
    }
    
    /**
     * Java options getter
     *
     * @return array
     */
    public function getJavaOptions()
    {
        return $this->java_options;
    }
}

/**
 *
 * Stanford POS Tagger Exception
 *
 */
class Exception extends \Exception {
    
}
