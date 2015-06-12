<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

use Exception;

class Functions
{
    public static function extractId()
    {
        return function ($object) {
            return $object->getId();
        };
    }

    public static function extractField($name, $accessPrivate = false)
    {
        return function ($object) use ($name, $accessPrivate) {
            return Objects::getValue($object, $name, null, $accessPrivate);
        };
    }

    public static function extractFieldRecursively($names, $accessPrivate = false)
    {
        return function ($object) use ($names, $accessPrivate) {
            return Objects::getValueRecursively($object, $names, null, $accessPrivate);
        };
    }

    public static function extractExpression($selector, $accessPrivate = false)
    {
        if (!is_string($selector)) {
            return $selector;
        } elseif (strpos($selector, '()') !== FALSE || strpos($selector, '->') !== FALSE) {
            return Functions::extractFieldRecursively($selector, $accessPrivate);
        } else {
            return Functions::extractField($selector, $accessPrivate);
        }
    }

    public static function identity()
    {
        return function ($object) {
            return $object;
        };
    }

    public static function constant($value)
    {
        return function () use ($value) {
            return $value;
        };
    }

    public static function throwException(Exception $exception)
    {
        return function () use ($exception) {
            throw $exception;
        };
    }

    public static function trim()
    {
        return function ($string) {
            return trim($string);
        };
    }

    public static function not($predicate)
    {
        return function ($object) use ($predicate) {
            return !$predicate($object);
        };
    }

    public static function isArray()
    {
        return function ($object) {
            return is_array($object);
        };
    }

    public static function isInstanceOf($type)
    {
        return function ($object) use ($type) {
            return $object instanceof $type;
        };
    }

    public static function prepend($prefix)
    {
        return function ($string) use ($prefix) {
            return $prefix . $string;
        };
    }

    public static function append($suffix)
    {
        return function ($string) use ($suffix) {
            return $string . $suffix;
        };
    }

    public static function notEmpty()
    {
        return function ($object) {
            return !empty($object);
        };
    }

    public static function notBlank()
    {
        return function ($string) {
            return Strings::isNotBlank($string);
        };
    }

    public static function removePrefix($prefix)
    {
        return function ($string) use ($prefix) {
            return Strings::removePrefix($string, $prefix);
        };
    }

    public static function startsWith($prefix)
    {
        return function ($string) use ($prefix) {
            return Strings::startsWith($string, $prefix);
        };
    }

    public static function formatDateTime($format = Date::DEFAULT_TIME_FORMAT)
    {
        return function ($date) use ($format) {
            return Date::formatDateTime($date, $format);
        };
    }

    public static function call($function, $argument)
    {
        return call_user_func($function, $argument);
    }

    /**
     * Returns the composition of two functions.
     * composition is defined as the function h such that h(a) == A(B(a)) for each a.
     * @param $functionA
     * @param $functionB
     * @return callable
     */
    public static function compose($functionA, $functionB)
    {
        return function ($input) use ($functionA, $functionB) {
            return Functions::call($functionA, Functions::call($functionB, $input));
        };
    }

    public static function toString()
    {
        return function ($object) {
            return Objects::toString($object);
        };
    }

    /**
     * @SuppressWarnings("unused")
     * $type is just a hint for dynamicReturnType plugin
     */
    public static function extract($type = null)
    {
        return new NonCallableExtractor();
    }

    public static function surroundWith($character)
    {
        return function ($string) use ($character) {
            return $character . $string . $character;
        };
    }

    public static function equals($object)
    {
        return function ($value) use ($object) {
            return $value == $object;
        };
    }

    public static function notEquals($object)
    {
        return function ($value) use ($object) {
            return $value != $object;
        };
    }
}
