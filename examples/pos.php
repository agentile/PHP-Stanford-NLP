<?php
// assume composer autoload
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$path = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'stanford-postagger-2017-06-09';

$pos = new \StanfordNLP\POSTagger(
  $path . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'english-left3words-distsim.tagger',
  $path . DIRECTORY_SEPARATOR . 'stanford-postagger-3.8.0.jar'
);

//$pos->setDebug(true);

$result = $pos->tag(explode(' ', "What does the fox say?"));
var_dump($result);
