Ouzo Goodies
==============

What is it
----------

Utility classes, test assertions and mocking framework extracted from [Ouzo framework](http://ouzoframework.org). We are compatible with PHP 7.2 and later.

[![Build Status](https://travis-ci.org/letsdrink/ouzo.png?branch=master)](https://travis-ci.org/letsdrink/ouzo)
[![Coverage Status](https://coveralls.io/repos/letsdrink/ouzo/badge.svg)](https://coveralls.io/r/letsdrink/ouzo)
[![Latest Stable Version](https://poser.pugx.org/letsdrink/ouzo-goodies/v/stable.svg)](https://packagist.org/packages/letsdrink/ouzo-goodies)
[![Total Downloads](https://poser.pugx.org/letsdrink/ouzo-goodies/downloads.svg)](https://packagist.org/packages/letsdrink/ouzo-goodies)
[![License](https://poser.pugx.org/letsdrink/ouzo-goodies/license.svg)](https://packagist.org/packages/letsdrink/ouzo-goodies)

How to use it
-------------

Couple of examples.

[Fluent arrays](http://ouzo.readthedocs.org/en/latest/utils/fluent_array.html):
```php
$result = FluentArray::from($users)
             ->map(Functions::extractField('name'))
             ->filter(Functions::notEmpty())
             ->unique()
             ->toArray();
```

[Fluent iterator](http://ouzo.readthedocs.org/en/latest/utils/fluent_iterator.html):
```php
$result = FluentIterator::fromArray([1, 2, 3])
             ->cycle()
             ->limit(10)
             ->reindex()
             ->toArray(); // [1, 2, 3, 1, 2, 3, 1, 2, 3, 1]
```

[Fluent functions](http://ouzo.readthedocs.org/en/latest/utils/fluent_functions.html):
```php
$product = new Product(['name' => 'super phone']);

$function = FluentFunctions::extractField('name')
      ->removePrefix('super')
      ->prepend(' extra')
      ->append('! ')
      ->surroundWith("***");

$result = Functions::call($function, $product); //=> '*** extra phone! ***'
```

```php
$phones = Arrays::filter($products, FluentFunctions::extractField('type')->equals('PHONE'));
```

[Extract (from Functions)](http://ouzo.readthedocs.org/en/latest/utils/functions.html#extract):
```php
$cities = Arrays::map($users, Functions::extract()->getAddress('home')->city);
```

[Clock](http://ouzo.readthedocs.org/en/latest/utils/clock.html):
```php
$string = Clock::now()
    ->plusYears(1)
    ->plusMonths(2)
    ->minusDays(3)
    ->format();
```

[Comparators](http://ouzo.readthedocs.org/en/latest/utils/comparators.html):
```php
$product1 = new Product(['name' => 'b']);
$product2 = new Product(['name' => 'c']);
$product3 = new Product(['name' => 'a']);

$result = Arrays::sort([$product1, $product2, $product3], Comparator::compareBy('name'));
```

[Fluent assertions for arrays](http://ouzo.readthedocs.org/en/latest/documentation/tests.html#array-assertions):
```php
$animals = ['cat', 'dog', 'pig'];
Assert::thatArray($animals)->hasSize(3)->contains('cat');
```

[Fluent assertions for strings](http://ouzo.readthedocs.org/en/latest/documentation/tests.html#string-assertions):
```php
Assert::thatString("Frodo")
     ->startsWith("Fro")
     ->endsWith("do")
     ->contains("rod")
     ->doesNotContain("fro")
     ->hasSize(5);
```

[Mocking](http://ouzo.readthedocs.org/en/latest/documentation/tests.html#mocking):
```php
$mock = Mock::create();
Mock::when($mock)->someMethod('arg')->thenReturn('123');

$result = $mock->someMethod('arg');

$this->assertEquals('123', $result);
Mock::verify($mock)->method('arg');
```

[Exception assertions](http://ouzo.readthedocs.org/en/latest/documentation/tests.html#exception-assertions):
```php
$foo = new Foo();

CatchException::when($foo)->method();

CatchException::assertThat()->isInstanceOf("FooException");
```

This is just a taste of Ouzo. Look at the documentation for more goodies.

Where to get it
---------------

Download from github or simply add composer dependency:
```sh
composer require letsdrink/ouzo-goodies
```

[Ouzo Goodies at packagist](https://packagist.org/packages/letsdrink/ouzo-goodies).

Documentation
-------------

Tutorials:
* [Functional programming with Ouzo](http://ouzo.readthedocs.org/en/latest/documentation/functional_programming.html)

Utilities:
* [Arrays](http://ouzo.readthedocs.org/en/latest/utils/arrays.html) - Helper functions for arrays.
* [FluentArray](http://ouzo.readthedocs.org/en/latest/utils/fluent_array.html) - Interface for manipulating arrays in a chained fashion.
* [Iterators](http://ouzo.readthedocs.org/en/latest/utils/iterators.html) - Helper functions for iterators.
* [FluentIterator](http://ouzo.readthedocs.org/en/latest/utils/fluent_iterator.html)- Interface for manipulating iterators in a chained fashion.
* [Strings](http://ouzo.readthedocs.org/en/latest/utils/strings.html) - Helper functions for strings.
* [Objects](http://ouzo.readthedocs.org/en/latest/utils/objects.html)- Helper functions that can operate on any PHP object.
* [Functions](http://ouzo.readthedocs.org/en/latest/utils/functions.html) - Static utility methods returning closures that can be used with Arrays and FluentArray, or other PHP functions.
* [FluentFunctions](http://ouzo.readthedocs.org/en/latest/utils/fluent_functions.html) - Fluent utility for function composition.
* [Cache](http://ouzo.readthedocs.org/en/latest/utils/cache.html) - General-purpose cache.
* [Path](http://ouzo.readthedocs.org/en/latest/utils/path.html) - Helper functions for path operations.
* [Clock](http://ouzo.readthedocs.org/en/latest/utils/clock.html) - DateTime replacement.
* [Comparators](http://ouzo.readthedocs.org/en/latest/utils/comparators.html) - Sorting.

Tests:
* [Assertions for arrays](http://ouzo.readthedocs.org/en/latest/documentation/tests.html#array-assertions)
* [Assertions for exceptions](http://ouzo.readthedocs.org/en/latest/documentation/tests.html#exception-assertions)
* [Assertions for strings](http://ouzo.readthedocs.org/en/latest/documentation/tests.html#string-assertions)
* [Mocking](http://ouzo.readthedocs.org/en/latest/documentation/tests.html#mocking)
* [Testing time-dependent code](http://ouzo.readthedocs.org/en/latest/documentation/tests.html#testing-time-dependent-code)

Check out full docs at http://ouzo.readthedocs.org

PhpStorm plugins:
-----------------
 * [Ouzo framework plugin](http://plugins.jetbrains.com/plugin/7565?pr=)
 * [DynamicReturnTypePlugin](http://plugins.jetbrains.com/plugin/7251) - for Mock and CatchException. You have to copy [dynamicReturnTypeMeta.json ](https://github.com/letsdrink/ouzo/blob/master/dynamicReturnTypeMeta.json) to your project root.

For ideas, questions, discussions write to *ouzo-framework@googlegroups.com*.

Support for PHP 5.6, 7.0 and 7.1
-----------------

Ouzo has dropped support for PHP versions older than 7.2 since Ouzo 2.x. If you want to use Ouzo with PHP 5.6, 7.0 or 7.1, please try Ouzo 1.x branch.