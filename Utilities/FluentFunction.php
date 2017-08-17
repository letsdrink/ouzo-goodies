<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

/**
 * Class FluentFunction
 * @package Ouzo\Utilities
 *
 * @method FluentFunction extractId()
 * @method FluentFunction extractField($expression, $boolean)
 * @method FluentFunction extractFieldRecursively($expression, $boolean)
 * @method FluentFunction extractExpression($expression, $boolean)
 * @method FluentFunction identity()
 * @method FluentFunction constant($value)
 * @method FluentFunction random($min, $max)
 * @method FluentFunction throwException($exception)
 * @method FluentFunction trim()
 * @method FluentFunction not($predicate)
 * @method FluentFunction isArray()
 * @method FluentFunction isInstanceOf($value)
 * @method FluentFunction prepend($string)
 * @method FluentFunction append($string)
 * @method FluentFunction notEmpty()
 * @method FluentFunction notBlank()
 * @method FluentFunction notNull()
 * @method FluentFunction removePrefix($string)
 * @method FluentFunction startsWith($string)
 * @method FluentFunction endsWith($string)
 * @method FluentFunction containsSubstring($string)
 * @method FluentFunction formatDateTime($format)
 * @method FluentFunction compose($fa, $fb)
 * @method FluentFunction toString()
 * @method FluentFunction surroundWith($string)
 * @method FluentFunction equals($value)
 * @method FluentFunction notEquals($value)
 * @method FluentFunction contains($value)
 * @method FluentFunction inArray($array)
 * @method FluentFunction notInArray($array)
 */
class FluentFunction
{
    private $_functions = [];

    public function __call($name, $arguments)
    {
        $this->_functions[] = call_user_func_array([Functions::class, $name], $arguments);
        return $this;
    }

    public function __invoke($object)
    {
        foreach ($this->_functions as $function) {
            $object = Functions::call($function, $object);
        }
        return $object;
    }

    public function negate()
    {
        $this->_functions[] = function ($object) {
            return !$object;
        };
        return $this;
    }
}
