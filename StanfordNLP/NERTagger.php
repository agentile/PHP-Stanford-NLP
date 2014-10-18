<?php
/**
 * PHP interface for Stanford NER
 * http://nlp.stanford.edu/software/CRF-NER.shtml
 *
 *
 * @link https://github.com/agentile/PHP-Stanford-NLP
 * @version 0.1.0
 * @author Anthony Gentile <asgentile@gmail.com>
 */
namespace StanfordNLP;

class NERTagger extends StanfordTagger {

    /**
     * NER classifier file
     */
    protected $classifier;

    /**
     * Constructor!
     *
     * @param $classifier string path to classifier file
     * @param $jar string path stanford ner jar file
     * @param $java_options mixed command line arguments to pass
     *
     * @return null
     */
    public function __construct($classifier, $jar, $java_options = array('-mx300m'))
    {
        parent::__construct();
        $this->setClassifier($classifier);
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
        $this->setSeparator('/');
        $this->setTagType('ner');
        return parent::batchTag($sentences);
    }

    /**
     * Classifier setter
     *
     * @param $classifier string path to classifier file
     *
     * @return mixed
     */
    public function setClassifier($classifier)
    {
        if (file_exists($classifier)) {
            $this->classifier = $classifier;
        } else {
            throw new Exception("Classifier file path does not exist.");
        }
    }

    /**
     * Classifier getter
     *
     * @return mixed
     */
    public function getClassifier()
    {
        return $this->classifier;
    }
}
