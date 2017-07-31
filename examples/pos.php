<?php
// assume composer autoload
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$path = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'stanford-postagger-2017-06-09';

$pos = new \StanfordNLP\POSTagger(
  $path . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'english-left3words-distsim.tagger',
  $path . DIRECTORY_SEPARATOR . 'stanford-postagger-3.8.0.jar'
);

//$pos->setDebug(true);

$result = $pos->tag(explode(' ', "What does the fox say? What does the parrot say?"));
//$results = $pos->batchTag([explode(' ', "What does the fox say?"), explode(' ', "What does the parrot say?")]);
var_dump($result);

/*
array(2) {
  [0]=>
  array(6) {
    [0]=>
    array(2) {
      [0]=>
      string(4) "What"
      [1]=>
      string(2) "WP"
    }
    [1]=>
    array(2) {
      [0]=>
      string(4) "does"
      [1]=>
      string(3) "VBZ"
    }
    [2]=>
    array(2) {
      [0]=>
      string(3) "the"
      [1]=>
      string(2) "DT"
    }
    [3]=>
    array(2) {
      [0]=>
      string(3) "fox"
      [1]=>
      string(2) "NN"
    }
    [4]=>
    array(2) {
      [0]=>
      string(3) "say"
      [1]=>
      string(2) "VB"
    }
    [5]=>
    array(2) {
      [0]=>
      string(1) "?"
      [1]=>
      string(1) "."
    }
  }
  [1]=>
  array(6) {
    [0]=>
    array(2) {
      [0]=>
      string(4) "What"
      [1]=>
      string(2) "WP"
    }
    [1]=>
    array(2) {
      [0]=>
      string(4) "does"
      [1]=>
      string(3) "VBZ"
    }
    [2]=>
    array(2) {
      [0]=>
      string(3) "the"
      [1]=>
      string(2) "DT"
    }
    [3]=>
    array(2) {
      [0]=>
      string(6) "parrot"
      [1]=>
      string(2) "NN"
    }
    [4]=>
    array(2) {
      [0]=>
      string(3) "say"
      [1]=>
      string(2) "VB"
    }
    [5]=>
    array(2) {
      [0]=>
      string(1) "?"
      [1]=>
      string(1) "."
    }
  }
}
*/
