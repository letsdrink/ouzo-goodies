<?php

namespace Ouzo\Utilities\Iterator;


use ArrayIterator;
use Iterator;

class UnbatchingIterator implements Iterator
{
    /**
     * @var Iterator $iterator
     */
    private $iterator;

    /**
     * @var Iterator $iterator
     */
    private $chunkIterator;
    private $position = 0;

    public function __construct(Iterator $iterator)
    {
        $this->iterator = $iterator;
        $this->chunkIterator = $this->createChunkIterator();
    }

    public function current()
    {
        return $this->chunkIterator->current();
    }

    public function next()
    {
        $this->position++;
        $this->chunkIterator->next();
        if (!$this->chunkIterator->valid()) {
            $this->iterator->next();
            if ($this->iterator->valid()) {
                $current = $this->iterator->current();
                $this->chunkIterator = new ArrayIterator($current);
            }
        }
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return $this->chunkIterator->valid();
    }

    public function rewind()
    {
        $this->position = 0;
        $this->iterator->rewind();
        $this->chunkIterator = $this->createChunkIterator();
    }

    private function createChunkIterator()
    {
        return new ArrayIterator($this->iterator->valid() ? $this->iterator->current() : array());
    }
}