<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities\Iterator;

class ReindexingIterator extends ForwardingIterator
{
    /** @var int */
    private $index;

    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        parent::next();
        $this->index++;
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        parent::rewind();
        $this->index = 0;
    }
}
