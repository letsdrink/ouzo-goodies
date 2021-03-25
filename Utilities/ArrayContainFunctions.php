<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

class ArrayContainFunctions
{
    public static function contains(array $array, mixed $element): bool
    {
        return Arrays::any($array, Functions::equals($element));
    }

    public static function containsAll(array $array, array $elements): bool
    {
        if (empty($elements) || !is_array($elements)) {
            return false;
        }
        foreach ($elements as $element) {
            if (!Arrays::contains($array, $element)) {
                return false;
            }
        }
        return true;
    }
}
