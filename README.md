PHP-Stanford-POS-Tagger
=======================

PHP interface to Stanford POS Tagger

http://nlp.stanford.edu/downloads/tagger.shtml

Mimicks http://nltk.org/_modules/nltk/tag/stanford.html#StanfordTagger

### Example Usage ###

```
$pos = new \StanfordNLP\POSTagger('/path/to/stanford-postagger-2013-11-12/models/english-left3words-distsim.tagger', '/path/to/stanford-postagger-2013-11-12/stanford-postagger.jar');
$result = $pos->tag(explode(' ', "Hello World!")); 
var_dump($result);

array(3) {
  [0]=>
  array(2) {
    [0]=>
    string(5) "Hello"
    [1]=>
    string(2) "UH"
  }
  [1]=>
  array(2) {
    [0]=>
    string(5) "World"
    [1]=>
    string(3) "NNP"
  }
  [2]=>
  array(2) {
    [0]=>
    string(1) "!"
    [1]=>
    string(1) "."
  }
}

```
