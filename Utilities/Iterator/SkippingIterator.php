<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities\Iterator;

use Iterator;

class SkippingIterator extends ForwardingIterator
{
    /** @var int */
    private $skipCount;
    /** @var bool */
    private $skipped = false;

    /**
     * @param Iterator $iterator
     * @param int $skip
     */
    public function __construct(Iterator $iterator, $skip)
    {
        parent::__construct($iterator);
        $this->skipCount = $skip;
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->skipped = false;
        $this->iterator->rewind();
    }
}
