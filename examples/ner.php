<?php
// assume composer autoload
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$path = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'stanford-ner-2017-06-09';

$pos = new \StanfordNLP\NERTagger(
  $path . DIRECTORY_SEPARATOR . 'classifiers' . DIRECTORY_SEPARATOR . 'english.all.3class.distsim.crf.ser.gz',
  $path . DIRECTORY_SEPARATOR . 'stanford-ner-3.8.0.jar'
);

//$pos->setDebug(true);

$result = $pos->tag(explode(' ', "The Federal Reserve Bank of New York led by Timothy R. Geithner."));
var_dump($result);
