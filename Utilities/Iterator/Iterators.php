<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Iterator;

use ArrayIterator;
use InfiniteIterator;
use InvalidArgumentException;
use Iterator;
use LimitIterator;

class Iterators
{
    /**
     * Returns an iterator that uses $function to generate elements
     * $function takes one argument which is the current position of the iterator.
     */
    public static function generate(callable $function): GeneratingIterator
    {
        return new GeneratingIterator($function);
    }

    /** Returns an iterator that cycles indefinitely over the elements of $iterator. */
    public static function cycle(Iterator $iterator): InfiniteIterator
    {
        return new InfiniteIterator($iterator);
    }

    /** Returns the elements of $iterator grouped in chunks of $chunkSize */
    public static function batch(Iterator $iterator, int $chunkSize, int $options = 0): BatchingIterator
    {
        return new BatchingIterator($iterator, $chunkSize, $options);
    }

    /** Returns the elements of $iterator that satisfy a predicate. */
    public static function filter(Iterator $iterator, callable $predicate): FilteringIterator
    {
        return new FilteringIterator($iterator, $predicate);
    }

    /** Copies an iterator's elements into an array. */
    public static function toArray(Iterator $iterator): array
    {
        return iterator_to_array($iterator);
    }

    /** Returns an iterator containing the elements of $array. */
    public static function forArray(array $array): ArrayIterator
    {
        return new ArrayIterator($array);
    }

    /** Returns an iterator that applies function to each element of $iterator. */
    public static function map(Iterator $iterator, callable $function): TransformingIterator
    {
        return new TransformingIterator($iterator, $function);
    }

    /** Returns the first element in iterator or defaultValue. */
    public static function firstOr(Iterator $iterator, mixed $default): mixed
    {
        $iterator->rewind();
        return $iterator->valid() ? $iterator->current() : $default;
    }

    /** Returns the first element in iterator or throws an Exception if iterator is empty */
    public static function first(Iterator $iterator): mixed
    {
        $iterator->rewind();
        if (!$iterator->valid()) {
            throw new InvalidArgumentException("Iterator is empty");
        }
        return $iterator->current();
    }

    /** Creates an iterator returning the first $number elements of the given iterator. */
    public static function limit(Iterator $iterator, int $number): LimitIterator
    {
        return new LimitIterator($iterator, 0, $number);
    }

    /** Creates an iterator returning all but first $number elements of the given iterator. */
    public static function skip(Iterator $iterator, int $number): SkippingIterator
    {
        return new SkippingIterator($iterator, $number);
    }

    /** Returns an iterator that indexes elements numerically starting from 0 */
    public static function reindex(Iterator $iterator): ReindexingIterator|Iterator
    {
        return new ReindexingIterator($iterator);
    }
}
