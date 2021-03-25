<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Iterator;

use Iterator;

class SkippingIterator extends ForwardingIterator
{
    private bool $skipped = false;

    public function __construct(Iterator $iterator, private int $skipCount)
    {
        parent::__construct($iterator);
    }

    public function valid(): bool
    {
        if (!$this->skipped) {
            for ($i = 0; $i < $this->skipCount; ++$i) {
                $this->iterator->next();
            }
            $this->skipped = true;
        }
        return parent::valid();
    }

    public function rewind(): void
    {
        $this->skipped = false;
        $this->iterator->rewind();
    }
}
