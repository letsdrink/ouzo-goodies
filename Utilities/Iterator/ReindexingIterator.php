<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
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
