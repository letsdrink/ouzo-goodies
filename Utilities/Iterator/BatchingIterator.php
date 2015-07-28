<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities\Iterator;

use Iterator;

class BatchingIterator implements Iterator
{
    /**
     * @var Iterator $iterator
     */
    private $iterator;
    private $chunkSize;

    /**
     * @var array $currentChunk
     */
    private $currentChunk;
    private $position = 0;

    public function __construct(Iterator $iterator, $chunkSize)
    {
        $this->iterator = $iterator;
        $this->chunkSize = $chunkSize;
    }

    public function rewind()
    {
        $this->position = 0;
        $this->iterator->rewind();
    }

    public function valid()
    {
        if (!isset($this->currentChunk)) {
            $this->fetchChunk();
        }
        return !empty($this->currentChunk);
    }

    public function key()
    {
        return $this->position;
    }

    public function current()
    {
        return $this->currentChunk;
    }

    public function next()
    {
        $this->position++;
        $this->fetchChunk();
    }

    private function fetchChunk()
    {
        $this->currentChunk = array();
        for ($i = 0; $i < $this->chunkSize && $this->iterator->valid(); $i++, $this->iterator->next()) {
            $this->currentChunk[] = $this->iterator->current();
        }
    }
}
