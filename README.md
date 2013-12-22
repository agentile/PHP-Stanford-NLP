# PHP-Stanford-NLP #

PHP interface to Stanford NLP Tools (POS Tagger, NER, etc)

## POS Tagger ##

http://nlp.stanford.edu/downloads/tagger.shtml

Mimicks http://nltk.org/_modules/nltk/tag/stanford.html#StanfordTagger

### Example Usage ###

```php
$pos = new \StanfordNLP\POSTagger(
  '/path/to/stanford-postagger-2013-11-12/models/english-left3words-distsim.tagger',
  '/path/to/stanford-postagger-2013-11-12/stanford-postagger.jar'
);
$result = $pos->tag(explode(' ', "What does the fox say?")); 
var_dump($result);

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


```

## NER Tagger ##

http://nlp.stanford.edu/software/CRF-NER.shtml

Mimicks http://nltk.org/_modules/nltk/tag/stanford.html#StanfordTagger

### Example Usage ###

```php
$pos = new \StanfordNLP\POSTagger(
  '/path/to/stanford-ner-2013-11-12/classifiers/english.all.3class.distsim.crf.ser.gz',
  '/path/to/stanford-ner-2013-11-12/stanford-ner.jar'
);
$result = $pos->tag(explode(' ', "The Federal Reserve Bank of New York led by Timothy R. Geithner.")); 
var_dump($result);

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

```
