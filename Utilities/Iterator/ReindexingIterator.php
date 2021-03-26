<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Iterator;

class ReindexingIterator extends ForwardingIterator
{
    private int $index;

    public function key(): int
    {
        return $this->index;
    }

    public function next(): void
    {
        parent::next();
        $this->index++;
    }

    public function rewind(): void
    {
        parent::rewind();
        $this->index = 0;
    }
}
