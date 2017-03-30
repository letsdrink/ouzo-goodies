<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

class ArrayContainFunctions
{
    /**
     * @param array $array
     * @param string $element
     * @return bool
     */
    public static function contains(array $array, $element)
    {
        return Arrays::any($array, Functions::equals($element));
    }

    /**
     * @param array $array
     * @param mixed $elements
     * @return bool
     */
    public static function containsAll(array $array, $elements)
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
