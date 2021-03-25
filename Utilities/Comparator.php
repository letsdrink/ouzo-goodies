<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

use Ouzo\Utilities\Comparator\Comparators;

/**
 * Class Comparator
 * @package Ouzo\Utilities
 */
class Comparator
{
    /**
     * Combines comparators into one resolving order using first comparator and resolving conflicts using tie breakers.
     * Second provided comparator is first tie breaker, third is second tie breaker and so on.
     *
     * @param mixed ...
     * @return callable
     */
    public static function compound()
    {
        return Comparators::compoundComparator(func_get_args());
    }

    /**
     * Returns comparator which compares objects by using values computed using given expressions.
     * Expressions should comply with format accepted by <code>Functions::extractExpression</code>.
     * Comparator returns an integer less than, equal to, or greater than zero if the first argument is considered to be respectively less than, equal to, or greater than the second.
     *
     * @param mixed ...
     * @return callable
     */
    public static function compareBy()
    {
        $expressions = func_get_args();
        $comparators = Arrays::map($expressions, fn($expression) => Comparators::evaluatingComparator(Functions::extractExpression($expression)));
        return sizeof($comparators) == 1 ? $comparators[0] : Comparators::compoundComparator($comparators);
    }

    /**
     * Returns comparator according to which order between element is reversed.
     *
     * @param $comparator
     * @return callable
     */
    public static function reverse($comparator)
    {
        return Comparators::reversedComparator($comparator);
    }

    /**
     * Returns a comparator that uses default comparison operators.
     *
     * @return callable
     */
    public static function natural()
    {
        return fn($a, $b) => $a <=> $b;
    }
}
