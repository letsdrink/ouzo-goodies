<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities\Iterator;

use ArrayIterator;
use Iterator;

class UnbatchingIterator implements Iterator
{
    /** @var Iterator $iterator */
    private $iterator;
    /** @var Iterator $chunkIterator */
    private $chunkIterator;
    /** @var int */
    private $position = 0;

    /**
     * @param Iterator $iterator
     */
    public function __construct(Iterator $iterator)
    {
        $this->iterator = $iterator;
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        $this->initializeChunkIterator();
        return $this->chunkIterator->current();
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        $this->initializeChunkIterator();
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

    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        $this->initializeChunkIterator();
        return $this->chunkIterator->valid();
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->position = 0;
        $this->iterator->rewind();
        $this->chunkIterator = null;
    }

    /**
     * @return void
     */
    private function initializeChunkIterator()
    {
        if (!$this->chunkIterator) {
            $this->chunkIterator = new ArrayIterator($this->iterator->valid() ? $this->iterator->current() : []);
        }
    }
}
