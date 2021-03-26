<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Iterator;

use Iterator;

class FluentIterator extends ForwardingIterator
{
    public static function from(Iterator $iterator): static
    {
        return new self($iterator);
    }

    /** Returns a fluent iterator for $array */
    public static function fromArray(array $array): static
    {
        return new self(Iterators::forArray($array));
    }

    /**
     * Returns a fluent iterator that uses $function to generate elements
     * $function takes one argument which is the current position of the iterator.
     */
    public static function fromFunction(callable $function): static
    {
        return new self(Iterators::generate($function));
    }

    /** Returns a fluent iterator that applies function to each element of this fluent iterator. */
    public function map(callable $function): static
    {
        $this->iterator = Iterators::map($this->iterator, $function);
        return $this;
    }

    /** Returns the first element in this iterator or defaultValue. */
    public function firstOr(mixed $default): mixed
    {
        return Iterators::firstOr($this->iterator, $default);
    }

    /** Returns the first element in iterator or throws an Exception if iterator is empty */
    public function first(): mixed
    {
        return Iterators::first($this->iterator);
    }

    /** Returns a fluent iterator returning the first $number elements of of this fluent iterator. */
    public function limit(int $number): static
    {
        $this->iterator = Iterators::limit($this->iterator, $number);
        return $this;
    }

    /** Returns a fluent iterator returning all but first $number elements of this fluent iterator. */
    public function skip(int $number): static
    {
        $this->iterator = Iterators::skip($this->iterator, $number);
        return $this;
    }

    /** Returns a fluent iterator returning elements of this fluent iterator grouped in chunks of $chunkSize */
    public function batch(int $chunkSize): static
    {
        $this->iterator = Iterators::batch($this->iterator, $chunkSize);
        return $this;
    }

    /** Returns a fluent iterator that cycles indefinitely over the elements of this fluent iterator. */
    public function cycle(): static
    {
        $this->iterator = Iterators::cycle($this->iterator);
        return $this;
    }

    /** Returns an iterator that indexes elements numerically starting from 0 */
    public function reindex(): static
    {
        $this->iterator = Iterators::reindex($this->iterator);
        return $this;
    }

    /** Returns a fluent iterator returning elements of this fluent iterator that satisfy a predicate. */
    public function filter(callable $predicate): static
    {
        $this->iterator = Iterators::filter($this->iterator, $predicate);
        return $this;
    }

    /** Copies elements of this fluent iterator into an array. */
    public function toArray(): array
    {
        return Iterators::toArray($this->iterator);
    }
}
