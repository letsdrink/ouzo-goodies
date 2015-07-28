<?php

namespace Ouzo\Utilities\Iterator;

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
    private $predicate;

    public function __construct(Iterator $iterator, $predicate)
    {
        parent::__construct($iterator);
        $this->predicate = $predicate;
    }

    public function accept()
    {
        $predicate = $this->predicate;
        return $predicate($this->current());
    }
}