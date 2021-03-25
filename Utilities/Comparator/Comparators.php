<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */


namespace Ouzo\Utilities\Comparator;


use Closure;

class Comparators
{
    public static function compoundComparator(array $comparators): Closure
    {
        return function ($lhs, $rhs) use ($comparators) {
            foreach ($comparators as $comparator) {
                $result = $comparator($lhs, $rhs);
                if ($result != 0) {
                    return $result;
                }
            }
            return 0;
        };
    }

    public static function evaluatingComparator(Closure $toEvaluate): Closure
    {
        return function ($lhs, $rhs) use ($toEvaluate) {
            $lhsValue = $toEvaluate($lhs);
            $rhsValue = $toEvaluate($rhs);
            return $lhsValue <=> $rhsValue;
        };
    }

    public static function reversedComparator(Closure $comparator): Closure
    {
        return function ($lhs, $rhs) use ($comparator) {
            return -1 * $comparator($lhs, $rhs);
        };
    }
}