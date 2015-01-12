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
 * @method static FluentFunction extractField($expression)
 * @method static FluentFunction extractFieldRecursively($expression)
 * @method static FluentFunction extractExpression($expression)
 * @method static FluentFunction trim()
 * @method static FluentFunction isArray()
 * @method static FluentFunction prepend($string)
 * @method static FluentFunction append($string)
 * @method static FluentFunction notEmpty()
 * @method static FluentFunction notBlank()
 * @method static FluentFunction removePrefix($string)
 * @method static FluentFunction startsWith($string)
 * @method static FluentFunction formatDateTime($format)
 * @method static FluentFunction toString()
 * @method static FluentFunction surroundWith($string)
 * @method static FluentFunction equals($value)
 * @method static FluentFunction negate()
 * @method static FluentFunction notEquals($value)
 * @method static FluentFunction isInstanceOf($value)
 */
class FluentFunctions
{
    public static function __callStatic($name, $arguments)
    {
        $fluentFunction = new FluentFunction();
        return call_user_func_array(array($fluentFunction, $name), $arguments);
    }
}
