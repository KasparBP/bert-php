[![Build Status](https://travis-ci.org/TriKaspar/bert-php.png?branch=master)](https://travis-ci.org/TriKaspar/bert-php)[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/TriKaspar/bert-php/badges/quality-score.png?s=1959fe255ad985188e9a7535c18167a455eadc0e)](https://scrutinizer-ci.com/g/TriKaspar/bert-php/)

##Note - Work in progress  
This is a fork of https://github.com/dhotson/bert-php  
I made it composer compatible and eleminated the fdopen dependency.  


BERT
====

A BERT (Binary ERlang Term) serialization library for PHP based on
[Tom Preston-Werner's Ruby implementation](http://github.com/mojombo/bert).

It can encode PHP objects into BERT format and decode BERT binaries into PHP
objects.

See the BERT specification at [bert-rpc.org](http://bert-rpc.org).

To designate an atom, use the Bert::a() helper or the Bert_Atom class.
To designate tuples, use the Bert::t() helper or the Bert_Tuple class:

    Bert::t(Bert::a('foo'), array(1, 2, 3))
    new Bert_Tuple(array(new Bert_Atom('foo'), array(1, 2, 3)))


These will both be converted to (in Erlang syntax):

    {foo, [1, 2, 3]}

Usage
-----

    require_once 'classes/Bert.php'

    $bert = Bert::encode(
      Bert::t(
        Bert::a('user'),
        array('name' => 'TPW', 'nick' => 'mojombo')
      )
    );
    # => string(82) "#hduserhdbertddictllmnamemTPWjlmnickmmojombojj"

    Bert::decode($bert);
    # => Bert_Tuple (
           Bert_Atom ( 'user' ),
           Array (
             'name' => 'TPW',
             'nick' => 'mojombo'
           )
         )

