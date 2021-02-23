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
     *
     * @param mixed $var
     * @return string
     */
    public static function toString($var)
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

    private static function objectToString($object)
    {
        if (method_exists($object, '__toString')) {
            return (string)$object;
        }
        $array = get_object_vars($object);
        $elements = self::stringifyArrayElements($array);
        return get_class($object) . ' {' . implode(', ', $elements) . '}';
    }

    private static function stringifyArrayElements($array)
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

    private static function arrayToString(array $array)
    {
        $elements = self::stringifyArrayElements($array);
        return '[' . implode(', ', $elements) . ']';
    }

    /**
     * Convert boolean to string 'true' or 'false'.
     *
     * @param bool $var
     * @return string
     */
    public static function booleanToString($var)
    {
        return $var ? 'true' : 'false';
    }

    /**
     * @param mixed $object
     * @param string $names
     * @param mixed $value
     */
    public static function setValueRecursively($object, $names, $value)
    {
        $fields = explode('->', $names);
        $destinationField = array_pop($fields);
        $destinationObject = self::getValueRecursively($object, implode('->', $fields));
        if ($destinationObject !== null) {
            $destinationObject->$destinationField = $value;
        }
    }

    /**
     * @param mixed $object
     * @param string $names
     * @param null|mixed $default
     * @param bool $accessPrivate
     * @return mixed|null
     */
    public static function getValueRecursively($object, $names, $default = null, $accessPrivate = false)
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

    /**
     * @param mixed $object
     * @param string $field
     * @param mixed $default
     * @param bool $accessPrivate
     * @return mixed|null
     */
    public static function getValueOrCallMethod($object, $field, $default, $accessPrivate = false)
    {
        $value = self::getValue($object, $field, null, $accessPrivate);
        if ($value !== null) {
            return $value;
        }
        return self::callMethod($object, $field, $default);
    }

    /**
     * @param mixed $object
     * @param string $field
     * @param null|mixed $default
     * @param bool $accessPrivate
     * @return mixed|null
     */
    public static function getValue($object, $field, $default = null, $accessPrivate = false)
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

    /**
     * @param mixed $object
     * @param string $methodName
     * @param mixed $default
     * @return mixed
     */
    public static function callMethod($object, $methodName, $default)
    {
        $name = rtrim($methodName, '()');
        if (method_exists((object) $object, $name)) {
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
     * @param $a
     * @param $b
     * @return bool
     */
    public static function equal($a, $b)
    {
        if ($a === $b) {
            return true;
        }
        return self::_convertToComparable($a) == self::_convertToComparable($b);
    }

    public static function _convertToComparable($value)
    {
        if ($value === null) {
            return "____ouzo_null_marker_so_that_null_!=_''";
        }
        $type = gettype($value);
        if ($type == 'boolean') {
            $value = $value ? 'true' : 'false';
        } elseif ($type == 'array') {
            array_walk_recursive($value, function (&$value) {
                $value = Objects::_convertToComparable($value);
            });
        } elseif ($type != 'object') {
            $value = $type != 'object' ? (string)$value : $value;
        }
        return $value;
    }
}
