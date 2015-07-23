<?php

namespace Ouzo\Utilities\Iterator;


use CallbackFilterIterator;
use InfiniteIterator;

class FluentIterator extends ForwardingIterator
{
    public static function from($iterator)
    {
        return new self($iterator);
    }

    public static function fromArray($array)
    {
        return new self(new \ArrayIterator($array));
    }

    public static function fromGenerator($generator)
    {
        return new self(new GeneratingIterator($generator));
    }

    public function map($function)
    {
        $this->iterator = new TransformingIterator($this->iterator, $function);
        return $this;
    }

    public function firstOr($default)
    {
        return $this->iterator->valid() ? $this->iterator->current() : $default;
    }

    public function limit($number)
    {
        $this->iterator = new \LimitIterator($this->iterator, 0, $number);
        return $this;
    }

    public function skip($number)
    {
        $this->iterator = new \LimitIterator($this->iterator, $number);
        return $this;
    }

    public function batch($chunkSize)
    {
        $this->iterator = new BatchingIterator($this->iterator, $chunkSize);
        return $this;
    }

    public function cycle()
    {
        $this->iterator = new InfiniteIterator($this->iterator);
        return $this;
    }

    /**
     * Returns an iterator that indexes elements numerically starting from 0
     * @return $this
     */
    public function reindex()
    {
        $this->iterator = new ReindexingIterator($this->iterator);
        return $this;
    }

    public function filter($predicate)
    {
        $this->iterator = new CallbackFilterIterator($this->iterator, $predicate);
        return $this;
    }

    public function toArray()
    {
        return iterator_to_array($this->iterator);
    }
}