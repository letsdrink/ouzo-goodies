<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities\Comparator;

class ReversedComparator
{
    private $comparator;

    public function __construct($comparator)
    {
        $this->comparator = $comparator;
    }

    public function __invoke($lhs, $rhs)
    {
        $comparator = $this->comparator;
        return -1 * $comparator($lhs, $rhs);
    }
}
