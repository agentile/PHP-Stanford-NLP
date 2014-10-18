<?php
/**
 * PHP interface for Stanford POS Tagger
 * http://nlp.stanford.edu/downloads/tagger.shtml
 *
 * Part-Of-Speech Tag List
 * http://www.ling.upenn.edu/courses/Fall_2003/ling001/penn_treebank_pos.html
 *
 * @link https://github.com/agentile/PHP-Stanford-NLP
 * @version 0.1.0
 * @author Anthony Gentile <asgentile@gmail.com>
 */
namespace StanfordNLP;

class POSTagger extends StanfordTagger {

    /**
     * Tagger model file
     */
    protected $model;

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
        parent::__construct();
        $this->setModel($model);
        $this->setJar($jar);
        $this->setJavaOptions($java_options);
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
        $this->setTagType('pos');
        return parent::batchTag($sentences);
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
            throw new Exception("Model file path does not exist.");
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
}
