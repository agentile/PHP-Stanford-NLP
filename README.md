# PHP-Stanford-NLP #

PHP interface to Stanford NLP Tools (POS Tagger, NER, Parser)

This library was tested against individual jar files for each package (version 3.4.1).

It was NOT built for use with the [Stanford CoreNLP](http://nlp.stanford.edu/software/corenlp.shtml).

### Installation

This library requires PHP 5.3 or later.

It is available via Composer as [agentile/php-stanford-nlp](https://packagist.org/packages/agentile/php-stanford-nlp).

You may also clone this repository, then require or include its _autoload.php_ file.

## POS Tagger ##

[http://nlp.stanford.edu/downloads/tagger.shtml](http://nlp.stanford.edu/downloads/tagger.shtml)

Mimicks http://nltk.org/_modules/nltk/tag/stanford.html#StanfordTagger

### Example Usage ###

```php
$pos = new \StanfordNLP\POSTagger(
  '/path/to/stanford-postagger-2014-08-27/models/english-left3words-distsim.tagger',
  '/path/to/stanford-postagger-2014-08-27/stanford-postagger.jar'
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

[http://nlp.stanford.edu/software/CRF-NER.shtml](http://nlp.stanford.edu/software/CRF-NER.shtml)

Mimicks http://nltk.org/_modules/nltk/tag/stanford.html#StanfordTagger

### Example Usage ###

```php
$pos = new \StanfordNLP\NERTagger(
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

## Parser ##

[http://nlp.stanford.edu/software/lex-parser.shtml](http://nlp.stanford.edu/software/lex-parser.shtml)

### Example Usage ###

```php
$parser = new \StanfordNLP\Parser(
  '/path/to/stanford-parser-full-2014-08-27/stanford-parser.jar',
  '/path/to/stanford-parser-full-2014-08-27/stanford-parser-3.4.1-models.jar'
);
$result = $parser->parseSentence("What does the fox say?");
var_dump($result);

array(3) {
  ["wordsAndTags"]=>
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
  ["penn"]=>
  array(2) {
    ["parent"]=>
    string(4) "ROOT"
    ["children"]=>
    array(1) {
      [0]=>
      array(2) {
        ["parent"]=>
        string(5) "SBARQ"
        ["children"]=>
        array(3) {
          [0]=>
          array(2) {
            ["parent"]=>
            string(4) "WHNP"
            ["children"]=>
            array(1) {
              [0]=>
              array(2) {
                ["parent"]=>
                string(7) "WP What"
                ["children"]=>
                array(0) {
                }
              }
            }
          }
          [1]=>
          array(2) {
            ["parent"]=>
            string(2) "SQ"
            ["children"]=>
            array(3) {
              [0]=>
              array(2) {
                ["parent"]=>
                string(8) "VBZ does"
                ["children"]=>
                array(0) {
                }
              }
              [1]=>
              array(2) {
                ["parent"]=>
                string(2) "NP"
                ["children"]=>
                array(2) {
                  [0]=>
                  array(2) {
                    ["parent"]=>
                    string(6) "DT the"
                    ["children"]=>
                    array(0) {
                    }
                  }
                  [1]=>
                  array(2) {
                    ["parent"]=>
                    string(6) "NN fox"
                    ["children"]=>
                    array(0) {
                    }
                  }
                }
              }
              [2]=>
              array(2) {
                ["parent"]=>
                string(2) "VP"
                ["children"]=>
                array(1) {
                  [0]=>
                  array(2) {
                    ["parent"]=>
                    string(6) "VB say"
                    ["children"]=>
                    array(0) {
                    }
                  }
                }
              }
            }
          }
          [2]=>
          array(2) {
            ["parent"]=>
            string(3) ". ?"
            ["children"]=>
            array(0) {
            }
          }
        }
      }
    }
  }
  ["typedDependencies"]=>
  array(5) {
    [0]=>
    array(3) {
      ["type"]=>
      string(4) "dobj"
      [0]=>
      array(2) {
        ["feature"]=>
        string(3) "say"
        ["index"]=>
        int(5)
      }
      [1]=>
      array(2) {
        ["feature"]=>
        string(4) "What"
        ["index"]=>
        int(1)
      }
    }
    [1]=>
    array(3) {
      ["type"]=>
      string(3) "aux"
      [0]=>
      array(2) {
        ["feature"]=>
        string(3) "say"
        ["index"]=>
        int(5)
      }
      [1]=>
      array(2) {
        ["feature"]=>
        string(4) "does"
        ["index"]=>
        int(2)
      }
    }
    [2]=>
    array(3) {
      ["type"]=>
      string(3) "det"
      [0]=>
      array(2) {
        ["feature"]=>
        string(3) "fox"
        ["index"]=>
        int(4)
      }
      [1]=>
      array(2) {
        ["feature"]=>
        string(3) "the"
        ["index"]=>
        int(3)
      }
    }
    [3]=>
    array(3) {
      ["type"]=>
      string(5) "nsubj"
      [0]=>
      array(2) {
        ["feature"]=>
        string(3) "say"
        ["index"]=>
        int(5)
      }
      [1]=>
      array(2) {
        ["feature"]=>
        string(3) "fox"
        ["index"]=>
        int(4)
      }
    }
    [4]=>
    array(3) {
      ["type"]=>
      string(4) "root"
      [0]=>
      array(2) {
        ["feature"]=>
        string(4) "ROOT"
        ["index"]=>
        int(0)
      }
      [1]=>
      array(2) {
        ["feature"]=>
        string(3) "say"
        ["index"]=>
        int(5)
      }
    }
  }
}


```
