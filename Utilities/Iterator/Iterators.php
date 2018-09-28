<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities\Iterator;

use ArrayIterator;
use Closure;
use InfiniteIterator;
use InvalidArgumentException;
use Iterator;
use LimitIterator;

class Iterators
{
    /**
     * Returns an iterator that uses $function to generate elements
     * $function takes one argument which is the current position of the iterator.
     * @param Closure $function
     * @return GeneratingIterator
     */
    public static function generate($function)
    {
        return new GeneratingIterator($function);
    }

    /**
     * Returns an iterator that cycles indefinitely over the elements of $iterator.
     * @param Iterator $iterator
     * @return InfiniteIterator
     */
    public static function cycle(Iterator $iterator)
    {
        return new InfiniteIterator($iterator);
    }

    /**
     * Returns the elements of $iterator grouped in chunks of $chunkSize
     * @param Iterator $iterator
     * @param int $chunkSize
     * @param int $options
     * @return BatchingIterator
     */
    public static function batch(Iterator $iterator, $chunkSize, $options = 0)
    {
        return new BatchingIterator($iterator, $chunkSize, $options);
    }

    /**
     * Returns the elements of $iterator that satisfy a predicate.
     * @param Iterator $iterator
     * @param Closure $predicate
     * @return FilteringIterator
     */
    public static function filter(Iterator $iterator, $predicate)
    {
        return new FilteringIterator($iterator, $predicate);
    }

    /**
     * Copies an iterator's elements into an array.
     * @param Iterator $iterator
     * @return array
     */
    public static function toArray(Iterator $iterator)
    {
        return iterator_to_array($iterator);
    }

    /**
     * Returns an iterator containing the elements of $array.
     * @param $array
     * @return ArrayIterator
     */
    public static function forArray($array)
    {
        return new ArrayIterator($array);
    }

    /**
     * Returns an iterator that applies function to each element of $iterator.
     * @param Iterator $iterator
     * @param Closure $function
     * @return TransformingIterator
     */
    public static function map(Iterator $iterator, $function)
    {
        return new TransformingIterator($iterator, $function);
    }

    /**
     * Returns the first element in iterator or defaultValue.
     * @param Iterator $iterator
     * @param mixed $default
     * @return mixed
     */
    public static function firstOr(Iterator $iterator, $default)
    {
        $iterator->rewind();
        return $iterator->valid() ? $iterator->current() : $default;
    }

    /**
     * Returns the first element in iterator or throws an Exception if iterator is empty
     * @param Iterator $iterator
     * @return mixed
     */
    public static function first(Iterator $iterator)
    {
        $iterator->rewind();
        if (!$iterator->valid()) {
            throw new InvalidArgumentException("Iterator is empty");
        }
        return $iterator->current();
    }

    /**
     * Creates an iterator returning the first $number elements of the given iterator.
     * @param Iterator $iterator
     * @param int $number
     * @return LimitIterator
     */
    public static function limit(Iterator $iterator, $number)
    {
        return new LimitIterator($iterator, 0, $number);
    }

    /**
     * Creates an iterator returning all but first $number elements of the given iterator.
     * @param Iterator $iterator
     * @param int $number
     * @return SkippingIterator
     */
    public static function skip(Iterator $iterator, $number)
    {
        return new SkippingIterator($iterator, $number);
    }

    /**
     * Returns an iterator that indexes elements numerically starting from 0
     * @param Iterator $iterator
     * @return Iterator
     */
    public static function reindex(Iterator $iterator)
    {
        return new ReindexingIterator($iterator);
    }
}
