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

//$result = $parser->parseSentence("What does the fox say?");
$result = $parser->parseSentences(["What does the fox say?", "Hi bob, how are you?"]);
var_dump($result);

/*
array(2) {
  [0]=>
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
  [1]=>
  array(3) {
    ["wordsAndTags"]=>
    array(7) {
      [0]=>
      array(2) {
        [0]=>
        string(2) "Hi"
        [1]=>
        string(3) "NNP"
      }
      [1]=>
      array(2) {
        [0]=>
        string(3) "bob"
        [1]=>
        string(3) "VBP"
      }
      [2]=>
      array(2) {
        [0]=>
        string(1) ","
        [1]=>
        string(1) ","
      }
      [3]=>
      array(2) {
        [0]=>
        string(3) "how"
        [1]=>
        string(3) "WRB"
      }
      [4]=>
      array(2) {
        [0]=>
        string(3) "are"
        [1]=>
        string(3) "VBP"
      }
      [5]=>
      array(2) {
        [0]=>
        string(3) "you"
        [1]=>
        string(3) "PRP"
      }
      [6]=>
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
          string(1) "S"
          ["children"]=>
          array(2) {
            [0]=>
            array(2) {
              ["parent"]=>
              string(2) "NP"
              ["children"]=>
              array(1) {
                [0]=>
                array(2) {
                  ["parent"]=>
                  string(6) "NNP Hi"
                  ["children"]=>
                  array(0) {
                  }
                }
              }
            }
            [1]=>
            array(2) {
              ["parent"]=>
              string(2) "VP"
              ["children"]=>
              array(3) {
                [0]=>
                array(2) {
                  ["parent"]=>
                  string(7) "VBP bob"
                  ["children"]=>
                  array(0) {
                  }
                }
                [1]=>
                array(2) {
                  ["parent"]=>
                  string(3) ", ,"
                  ["children"]=>
                  array(0) {
                  }
                }
                [2]=>
                array(2) {
                  ["parent"]=>
                  string(5) "SBARQ"
                  ["children"]=>
                  array(3) {
                    [0]=>
                    array(2) {
                      ["parent"]=>
                      string(6) "WHADVP"
                      ["children"]=>
                      array(1) {
                        [0]=>
                        array(2) {
                          ["parent"]=>
                          string(7) "WRB how"
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
                      array(2) {
                        [0]=>
                        array(2) {
                          ["parent"]=>
                          string(7) "VBP are"
                          ["children"]=>
                          array(0) {
                          }
                        }
                        [1]=>
                        array(2) {
                          ["parent"]=>
                          string(2) "NP"
                          ["children"]=>
                          array(1) {
                            [0]=>
                            array(2) {
                              ["parent"]=>
                              string(7) "PRP you"
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
          }
        }
      }
    }
    ["typedDependencies"]=>
    array(5) {
      [0]=>
      array(3) {
        ["type"]=>
        string(5) "nsubj"
        [0]=>
        array(2) {
          ["feature"]=>
          string(3) "bob"
          ["index"]=>
          int(2)
        }
        [1]=>
        array(2) {
          ["feature"]=>
          string(2) "Hi"
          ["index"]=>
          int(1)
        }
      }
      [1]=>
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
          string(3) "bob"
          ["index"]=>
          int(2)
        }
      }
      [2]=>
      array(3) {
        ["type"]=>
        string(6) "advmod"
        [0]=>
        array(2) {
          ["feature"]=>
          string(3) "are"
          ["index"]=>
          int(5)
        }
        [1]=>
        array(2) {
          ["feature"]=>
          string(3) "how"
          ["index"]=>
          int(4)
        }
      }
      [3]=>
      array(3) {
        ["type"]=>
        string(5) "ccomp"
        [0]=>
        array(2) {
          ["feature"]=>
          string(3) "bob"
          ["index"]=>
          int(2)
        }
        [1]=>
        array(2) {
          ["feature"]=>
          string(3) "are"
          ["index"]=>
          int(5)
        }
      }
      [4]=>
      array(3) {
        ["type"]=>
        string(5) "nsubj"
        [0]=>
        array(2) {
          ["feature"]=>
          string(3) "are"
          ["index"]=>
          int(5)
        }
        [1]=>
        array(2) {
          ["feature"]=>
          string(3) "you"
          ["index"]=>
          int(6)
        }
      }
    }
  }
}
*/
