<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

use ReflectionObject;

/**
 * Class Objects
 * @package Ouzo\Utilities
 */
class Objects
{
    /**
     * Returns a string representation of the given object.
     */
    public static function toString(mixed $var): string
    {
        switch (gettype($var)) {
            case 'boolean':
                return self::booleanToString($var);
            case 'NULL':
                return "null";
            case 'string':
                return "\"$var\"";
            case 'object':
                return self::objectToString($var);
            case 'array':
                return self::arrayToString($var);
        }
        return "$var";
    }

    private static function objectToString(object $object): string
    {
        if (method_exists($object, '__toString')) {
            return (string)$object;
        }
        $array = get_object_vars($object);
        $elements = self::stringifyArrayElements($array);
        return get_class($object) . ' {' . implode(', ', $elements) . '}';
    }

    private static function stringifyArrayElements(array $array): array
    {
        $elements = [];
        $isAssociative = array_keys($array) !== range(0, sizeof($array) - 1);
        array_walk($array, function ($element, $key) use (&$elements, $isAssociative) {
            if ($isAssociative) {
                $elements[] = "<$key> => " . Objects::toString($element);
            } else {
                $elements[] = Objects::toString($element);
            }
        });
        return $elements;
    }

    private static function arrayToString(array $array): string
    {
        $elements = self::stringifyArrayElements($array);
        return '[' . implode(', ', $elements) . ']';
    }

    /**
     * Convert boolean to string 'true' or 'false'.
     */
    public static function booleanToString(bool $var): string
    {
        return $var ? 'true' : 'false';
    }

    public static function setValueRecursively(mixed $object, string $names, mixed $value): void
    {
        $fields = explode('->', $names);
        $destinationField = array_pop($fields);
        $destinationObject = self::getValueRecursively($object, implode('->', $fields));
        if ($destinationObject !== null) {
            $destinationObject->$destinationField = $value;
        }
    }

    public static function getValueRecursively(mixed $object, string $names, mixed $default = null, bool $accessPrivate = false): mixed
    {
        $fields = Arrays::filter(explode('->', $names), Functions::notBlank());
        foreach ($fields as $field) {
            $object = self::getValueOrCallMethod($object, $field, null, $accessPrivate);
            if ($object === null) {
                return $default;
            }
        }
        return $object;
    }

    public static function getValueOrCallMethod(mixed $object, string $field, mixed $default, bool $accessPrivate = false): mixed
    {
        $value = self::getValue($object, $field, null, $accessPrivate);
        if ($value !== null) {
            return $value;
        }
        return self::callMethod($object, $field, $default);
    }

    public static function getValue(mixed $object, string $field, mixed $default = null, bool $accessPrivate = false): mixed
    {
        if (is_array($object)) {
            return Arrays::getValue($object, $field, $default);
        }
        if (isset($object->$field)) {
            return $object->$field;
        }
        if ($accessPrivate) {
            $class = new ReflectionObject($object);
            if ($class->hasProperty($field)) {
                $property = $class->getProperty($field);
                $property->setAccessible(true);
                return $property->getValue($object);
            }
        }
        return $default;
    }

    public static function callMethod(mixed $object, string $methodName, mixed $default): mixed
    {
        $name = rtrim($methodName, '()');
        if (method_exists((object)$object, $name)) {
            $result = $object->$name();
            return $result === null ? $default : $result;
        }
        return $default;
    }

    /**
     * Returns true if $a is equal to $b. Comparison is based on the following rules:
     *  - same type + same type = strict check
     *  - object + object = loose check
     *  - array + array = compares arrays recursively with these rules
     *  - string + integer = loose check ('1' == 1)
     *  - boolean + string ('true' or 'false') = loose check
     *  - false in other cases ('' != null, '' != 0, '' != false)
     *
     * Example:
     * <code>
     * $result = Objects::equal(array('1'), array(1));
     * </code>
     * Result:
     * <code>
     * true
     * </code>
     */
    public static function equal(mixed $a, mixed $b): bool
    {
        if ($a === $b) {
            return true;
        }
        return self::convertToComparable($a) == self::convertToComparable($b);
    }

    public static function convertToComparable(mixed $value): mixed
    {
        if ($value === null) {
            return "____ouzo_null_marker_so_that_null_!=_''";
        }
        if (is_bool($value)) {
            $value = $value === true ? 'true' : 'false';
        } elseif (is_array($value)) {
            array_walk_recursive($value, function (&$value) {
                $value = Objects::convertToComparable($value);
            });
        } elseif (!is_object($value)) {
            $value = (string)$value;
        }
        return $value;
    }
}
