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
 * @method FluentFunction extractField($expression)
 * @method FluentFunction extractFieldRecursively($expression)
 * @method FluentFunction extractExpression($expression)
 * @method FluentFunction trim()
 * @method FluentFunction isArray()
 * @method FluentFunction prepend($string)
 * @method FluentFunction append($string)
 * @method FluentFunction notEmpty()
 * @method FluentFunction notBlank()
 * @method FluentFunction removePrefix($string)
 * @method FluentFunction startsWith($string)
 * @method FluentFunction formatDateTime($format)
 * @method FluentFunction toString()
 * @method FluentFunction surroundWith($string)
 * @method FluentFunction equals($value)
 * @method FluentFunction notEquals($value)
 * @method FluentFunction isInstanceOf($value)
 */
class FluentFunction
{
    private $_functions = array();

    public function __call($name, $arguments)
    {
        $this->_functions[] = call_user_func_array('Ouzo\Utilities\Functions::' . $name, $arguments);
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
