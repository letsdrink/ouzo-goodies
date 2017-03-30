<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities\Iterator;

use Closure;
use Iterator;

class TransformingIterator extends ForwardingIterator
{
    /** @var Closure */
    private $function;

    /**
     * @param Iterator $iterator
     * @param Closure $function
     */
    public function __construct(Iterator $iterator, $function)
    {
        parent::__construct($iterator);
        $this->function = $function;
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return call_user_func($this->function, $this->iterator->current());
    }
}
