<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities\Iterator;

use Closure;
use FilterIterator;
use Iterator;

/**
 * Class FilteringIterator
 * @package Ouzo\Utilities\Iterator
 *
 * For php 5.3 which does not support CallbackFilterIterator :(
 */
class FilteringIterator extends FilterIterator
{
    /** @var Closure */
    private $predicate;

    /**
     * @param Iterator $iterator
     * @param Closure $predicate
     */
    public function __construct(Iterator $iterator, $predicate)
    {
        parent::__construct($iterator);
        $this->predicate = $predicate;
    }

    /**
     * @return mixed
     */
    public function accept()
    {
        $predicate = $this->predicate;
        return $predicate($this->current());
    }
}
