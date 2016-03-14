<?php

namespace Ouzo\Utilities\Iterator;

use Iterator;

class SkippingIterator extends ForwardingIterator
{
    private $skipCount;
    private $skipped = false;

    public function __construct(Iterator $iterator, $skip)
    {
        parent::__construct($iterator);
        $this->skipCount = $skip;
    }

    public function valid()
    {
        if (!$this->skipped) {
            for ($i = 0; $i < $this->skipCount; ++$i) {
                $this->iterator->next();
            }
            $this->skipped = true;
        }
        return parent::valid();
    }

    public function rewind()
    {
        $this->skipped = false;
        $this->iterator->rewind();
    }
}