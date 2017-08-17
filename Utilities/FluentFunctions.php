<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

/**
 * Class FluentFunctions
 * @package Ouzo\Utilities
 *
 * @method static FluentFunction extractId()
 * @method static FluentFunction extractField($expression, $boolean = false)
 * @method static FluentFunction extractFieldRecursively($expression, $boolean = false)
 * @method static FluentFunction extractExpression($expression, $boolean = false)
 * @method static FluentFunction identity()
 * @method static FluentFunction constant($value)
 * @method static FluentFunction random($min, $max)
 * @method static FluentFunction throwException($exception)
 * @method static FluentFunction trim()
 * @method static FluentFunction not($predicate)
 * @method static FluentFunction isArray()
 * @method static FluentFunction isInstanceOf($value)
 * @method static FluentFunction prepend($string)
 * @method static FluentFunction append($string)
 * @method static FluentFunction notEmpty()
 * @method static FluentFunction notBlank()
 * @method static FluentFunction notNull()
 * @method static FluentFunction removePrefix($string)
 * @method static FluentFunction startsWith($string)
 * @method static FluentFunction endsWith($string)
 * @method static FluentFunction containsSubstring($string)
 * @method static FluentFunction formatDateTime($format)
 * @method static FluentFunction compose($fa, $fb)
 * @method static FluentFunction toString()
 * @method static FluentFunction surroundWith($string)
 * @method static FluentFunction equals($value)
 * @method static FluentFunction notEquals($value)
 * @method static FluentFunction contains($value)
 * @method static FluentFunction inArray($array)
 * @method static FluentFunction notInArray($array)
 * @method static FluentFunction negate()
 * @method static FluentFunction equalsIgnoreCase($string)
 */
class FluentFunctions
{
    public static function __callStatic($name, $arguments)
    {
        $fluentFunction = new FluentFunction();
        return call_user_func_array([$fluentFunction, $name], $arguments);
    }
}
