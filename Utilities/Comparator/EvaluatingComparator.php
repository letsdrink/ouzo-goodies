<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities\Comparator;

/**
 * Class EvaluatingComparator
 * @package Ouzo\Utilities\Comparator
 */
class EvaluatingComparator
{
    private $toEvaluate;

    public function __construct($toEvaluate)
    {
        $this->toEvaluate = $toEvaluate;
    }

    public function __invoke($lhs, $rhs)
    {
        $functionToEvaluate = $this->toEvaluate;
        $lhsValue = $functionToEvaluate($lhs);
        $rhsValue = $functionToEvaluate($rhs);
        return $this->compareEvaluated($lhsValue, $rhsValue);
    }

    private function compareEvaluated($lhsValue, $rhsValue)
    {
        if ($lhsValue == $rhsValue) {
            return 0;
        } else {
            return $lhsValue < $rhsValue ? -1 : 1;
        }
    }
}
