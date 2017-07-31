<?php
// assume composer autoload
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$path = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'stanford-ner-2017-06-09';

$pos = new \StanfordNLP\NERTagger(
  $path . DIRECTORY_SEPARATOR . 'classifiers' . DIRECTORY_SEPARATOR . 'english.all.3class.distsim.crf.ser.gz',
  $path . DIRECTORY_SEPARATOR . 'stanford-ner-3.8.0.jar'
);

//$pos->setDebug(true);

$result = $pos->tag(explode(' ', "The Federal Reserve Bank of New York led by Timothy R. Geithner. He also said that we should call the Internal Revenue Services office"));
//$results = $pos->batchTag([explode(' ', "The Federal Reserve Bank of New York led by Timothy R. Geithner."), explode(' ', "He also said that we should call the Internal Revenue Services office")]);
var_dump($result);

/*
array(2) {
  [0]=>
  array(13) {
    [0]=>
    array(2) {
      [0]=>
      string(3) "The"
      [1]=>
      string(1) "O"
    }
    [1]=>
    array(2) {
      [0]=>
      string(7) "Federal"
      [1]=>
      string(12) "ORGANIZATION"
    }
    [2]=>
    array(2) {
      [0]=>
      string(7) "Reserve"
      [1]=>
      string(12) "ORGANIZATION"
    }
    [3]=>
    array(2) {
      [0]=>
      string(4) "Bank"
      [1]=>
      string(12) "ORGANIZATION"
    }
    [4]=>
    array(2) {
      [0]=>
      string(2) "of"
      [1]=>
      string(12) "ORGANIZATION"
    }
    [5]=>
    array(2) {
      [0]=>
      string(3) "New"
      [1]=>
      string(12) "ORGANIZATION"
    }
    [6]=>
    array(2) {
      [0]=>
      string(4) "York"
      [1]=>
      string(12) "ORGANIZATION"
    }
    [7]=>
    array(2) {
      [0]=>
      string(3) "led"
      [1]=>
      string(1) "O"
    }
    [8]=>
    array(2) {
      [0]=>
      string(2) "by"
      [1]=>
      string(1) "O"
    }
    [9]=>
    array(2) {
      [0]=>
      string(7) "Timothy"
      [1]=>
      string(6) "PERSON"
    }
    [10]=>
    array(2) {
      [0]=>
      string(2) "R."
      [1]=>
      string(6) "PERSON"
    }
    [11]=>
    array(2) {
      [0]=>
      string(8) "Geithner"
      [1]=>
      string(6) "PERSON"
    }
    [12]=>
    array(2) {
      [0]=>
      string(1) "."
      [1]=>
      string(1) "O"
    }
  }
  [1]=>
  array(12) {
    [0]=>
    array(2) {
      [0]=>
      string(2) "He"
      [1]=>
      string(1) "O"
    }
    [1]=>
    array(2) {
      [0]=>
      string(4) "also"
      [1]=>
      string(1) "O"
    }
    [2]=>
    array(2) {
      [0]=>
      string(4) "said"
      [1]=>
      string(1) "O"
    }
    [3]=>
    array(2) {
      [0]=>
      string(4) "that"
      [1]=>
      string(1) "O"
    }
    [4]=>
    array(2) {
      [0]=>
      string(2) "we"
      [1]=>
      string(1) "O"
    }
    [5]=>
    array(2) {
      [0]=>
      string(6) "should"
      [1]=>
      string(1) "O"
    }
    [6]=>
    array(2) {
      [0]=>
      string(4) "call"
      [1]=>
      string(1) "O"
    }
    [7]=>
    array(2) {
      [0]=>
      string(3) "the"
      [1]=>
      string(1) "O"
    }
    [8]=>
    array(2) {
      [0]=>
      string(8) "Internal"
      [1]=>
      string(12) "ORGANIZATION"
    }
    [9]=>
    array(2) {
      [0]=>
      string(7) "Revenue"
      [1]=>
      string(12) "ORGANIZATION"
    }
    [10]=>
    array(2) {
      [0]=>
      string(8) "Services"
      [1]=>
      string(12) "ORGANIZATION"
    }
    [11]=>
    array(2) {
      [0]=>
      string(6) "office"
      [1]=>
      string(1) "O"
    }
  }
}
*/
