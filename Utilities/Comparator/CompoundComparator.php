<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities\Comparator;

use Closure;

/**
 * Class CompoundComparator
 * @package Ouzo\Utilities\Comparator
 */
class CompoundComparator
{
    /** @var Closure[] */
    private $comparators;

    /**
     * @param Closure[] $comparators
     */
    public function __construct(array $comparators)
    {
        $this->comparators = $comparators;
    }

    /**
     * @param mixed $lhs
     * @param mixed $rhs
     * @return mixed
     */
    public function __invoke($lhs, $rhs)
    {
        foreach ($this->comparators as $comparator) {
            $result = $comparator($lhs, $rhs);
            if ($result != 0) {
                return $result;
            }
        }
    }
}
