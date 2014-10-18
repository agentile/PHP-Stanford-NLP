<?php
/**
 * This file is part of the StanfordNLP for PHP.
 *
 * Base class, providing core functionality for several classes.
 *
 * @package StanfordNLP
 * @link https://github.com/agentile/PHP-Stanford-NLP
 * @version 0.1.0
 * @author Anthony Gentile <asgentile@gmail.com>
 */
namespace StanfordNLP;

/**
*
* Base Exception class for Stanford NLP
*
* @package StanfordNLP
*
*/
class Base {

    /**
     * Java path
     *
     * relative/absolute path to java
     * e.g. /usr/bin/java
     */
    protected $java_path = 'java'; // assume relative path to start

    /**
     * Stanford Jar file
     */
    protected $jar;

    /**
     * Stanford Models Jar file
     */
    protected $models_jar;

    /**
     * Java options to use with our jar instance
     */
    protected $java_options;

    /**
     * Output from NLP Tool
     */
    protected $output = null;

    /**
     * Errors from NLP Tool
     */
    protected $errors = null;

    /**
     * PHP Operating System
     */
    protected $php_os = 'linux';

    /**
     * Constructor!
     *   - Set PHP Operating System.
     *
     * @return null
     */
    public function __construct()
    {
        if (defined('PHP_OS')) {
            if (strtolower(substr(PHP_OS, 0, 3)) == 'win') {
                $this->php_os = 'windows';
            }
        }
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
            throw new Exception("Jar file path does not exist.");
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
     * Models Jar setter
     *
     * @param $jar string path to jar file
     *
     * @return null
     */
    public function setModelsJar($jar)
    {
        if (file_exists($jar)) {
            $this->models_jar = $jar;
        } else {
            throw new Exception("Models Jar file path does not exist.");
        }
    }

    /**
     * Models Jar getter
     *
     * @return mixed
     */
    public function getModelsJar()
    {
        return $this->models_jar;
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
}
