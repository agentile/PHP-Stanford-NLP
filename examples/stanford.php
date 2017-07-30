<?php
// assume composer autoload
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$path = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'stanford-parser-full-2017-06-09';

$parser = new \StanfordNLP\Parser(
  $path . DIRECTORY_SEPARATOR . 'stanford-parser.jar',
  $path . DIRECTORY_SEPARATOR . 'stanford-parser-3.8.0-models.jar'
);

//$parser->setDebug(true);
//$parser->setOutputFormat('penn');

$result = $parser->parseSentence("What does the fox say?");
var_dump($result);
