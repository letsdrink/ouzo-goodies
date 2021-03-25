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
    private ?Iterator $chunkIterator = null;
    private int $position = 0;

    public function __construct(private Iterator $iterator)
    {
    }

    public function current(): mixed
    {
        $this->initializeChunkIterator();
        return $this->chunkIterator->current();
    }

    public function next(): void
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

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        $this->initializeChunkIterator();
        return $this->chunkIterator->valid();
    }

    public function rewind(): void
    {
        $this->position = 0;
        $this->iterator->rewind();
        $this->chunkIterator = null;
    }

    private function initializeChunkIterator(): void
    {
        if (!$this->chunkIterator) {
            $this->chunkIterator = new ArrayIterator($this->iterator->valid() ? $this->iterator->current() : []);
        }
    }
}
