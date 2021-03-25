<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Iterator;

use Iterator;

class BatchingIterator implements Iterator
{
    const OPTION_PRESERVER_KEYS = 0x2;

    private Iterator $iterator;
    private int $chunkSize;
    private array $currentChunk;
    private int $position = 0;
    private bool $preserveKeys;

    public function __construct(Iterator $iterator, int $chunkSize, int $options = 0)
    {
        $this->iterator = $iterator;
        $this->chunkSize = $chunkSize;
        $this->preserveKeys = $options && self::OPTION_PRESERVER_KEYS;
    }

    public function rewind(): void
    {
        $this->position = 0;
        $this->iterator->rewind();
    }

    public function valid(): bool
    {
        if (!isset($this->currentChunk)) {
            $this->fetchChunk();
        }
        return !empty($this->currentChunk);
    }

    public function key(): int
    {
        return $this->position;
    }

    public function current(): array
    {
        return $this->currentChunk;
    }

    public function next(): void
    {
        $this->position++;
        $this->fetchChunk();
    }

    private function fetchChunk(): void
    {
        $this->currentChunk = [];
        for ($i = 0; $i < $this->chunkSize && $this->iterator->valid(); $i++, $this->iterator->next()) {
            $key = $this->preserveKeys ? $this->iterator->key() : $i;
            $this->currentChunk[$key] = $this->iterator->current();
        }
    }
}
