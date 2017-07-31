# PHP-Stanford-NLP #

PHP interface to Stanford NLP Tools (POS Tagger, NER, Parser)

This library was tested against individual jar files for each package version 3.8.0 (english).

It was NOT built for use with the [Stanford CoreNLP](http://nlp.stanford.edu/software/corenlp.shtml).

### Installation

This library requires PHP 5.3 or later.

It is available via Composer as [agentile/php-stanford-nlp](https://packagist.org/packages/agentile/php-stanford-nlp).

You may also clone this repository, then require or include its _autoload.php_ file.

## POS Tagger ##

[https://nlp.stanford.edu/software/tagger.html#Download](https://nlp.stanford.edu/software/tagger.html#Download)

Mimicks http://nltk.org/_modules/nltk/tag/stanford.html#StanfordTagger

### Example Usage ###

See examples [here](https://github.com/agentile/PHP-Stanford-NLP/tree/master/examples)

```php
$pos = new \StanfordNLP\POSTagger(
  '/path/to/stanford-postagger-2017-06-09/models/english-left3words-distsim.tagger',
  '/path/to/stanford-postagger-2017-06-09/stanford-postagger-3.8.0.jar'
);
$result = $pos->tag(explode(' ', "What does the fox say?"));
var_dump($result);
```

## NER Tagger ##

[https://nlp.stanford.edu/software/CRF-NER.shtml#Download](https://nlp.stanford.edu/software/CRF-NER.shtml#Download)

Mimicks http://nltk.org/_modules/nltk/tag/stanford.html#StanfordTagger

### Example Usage ###

```php
$pos = new \StanfordNLP\NERTagger(
  '/path/to/stanford-ner-2017-06-09/classifiers/english.all.3class.distsim.crf.ser.gz',
  '/path/to/stanford-ner-2017-06-09/stanford-ner-3.8.0.jar'
);
$result = $pos->tag(explode(' ', "The Federal Reserve Bank of New York led by Timothy R. Geithner."));
var_dump($result);
```

## Parser ##

[https://nlp.stanford.edu/software/lex-parser.shtml#Download](https://nlp.stanford.edu/software/lex-parser.shtml#Download)

### Example Usage ###

```php
$parser = new \StanfordNLP\Parser(
  '/path/to/stanford-parser-full-2017-06-09/stanford-parser.jar',
  '/path/to/stanford-parser-full-2017-06-09/stanford-parser-3.8.0-models.jar'
);
$result = $parser->parseSentence("What does the fox say?");
var_dump($result);
```
