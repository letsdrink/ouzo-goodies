<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

class ArrayContainFunctions
{
    public static function contains(array $array, $element)
    {
        if (is_array($element)) {
            return self::containsArray($array, $element);
        }
        return self::containsElement($array, $element);
    }

    public static function containsArray(array $array, array $elements)
    {
        if (empty($elements)) {
            return false;
        }
        foreach ($elements as $element) {
            foreach ($array as $arrayElements) {
                if (Arrays::contains($arrayElements, $element)) {
                    continue 2;
                }
            }
            return false;
        }
        return true;
    }

    public static function containsElement(array $array, $element)
    {
        foreach ($array as $value) {
            if (self::isEqual($value, $element)) {
                return true;
            }
        }
        return false;
    }

    private static function isEqual($var1, $var2)
    {
        $type1 = gettype($var1);
        $type2 = gettype($var2);
        if ($var1 === $var2) {
            return true;
        }
        if ($type1 == $type2 && ($type1 == 'object' || $type1 == 'array') && $var1 == $var2) {
            return true;
        }
        if (self::bothEquals($type1, $type2, 'string', 'integer') && $var1 == $var2) {
            return true;
        }
        if (self::bothEquals($type1, $type2, 'boolean', 'string') && self::anyEquals($var1, $var2, 'true', 'false') && Booleans::toBoolean($var1) == Booleans::toBoolean($var2)) {
            return true;
        }
        return false;
    }

    private static function bothEquals($var1, $var2, $value1, $value2)
    {
        return ($var1 === $value1 && $var2 === $value2) || ($var1 === $value2 && $var2 === $value1);
    }

    private static function anyEquals($var1, $var2, $value1, $value2)
    {
        return $var1 === $value1 || $var1 === $value2 || $var2 === $value1 || $var2 === $value2;
    }
}