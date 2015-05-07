<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

use Exception;
use InvalidArgumentException;

/**
 * Class Arrays
 * @package Ouzo\Utilities
 */
class Arrays
{
    const TREAT_NULL_AS_VALUE = 1;

    /**
     * Returns true if every element in array satisfies the predicate.
     *
     * Example:
     * <code>
     * $array = array(1, 2);
     * $all = Arrays::all($array, function ($element) {
     *      return $element < 3;
     * });
     * </code>
     * Result:
     * <code>
     * true
     * </code>
     *
     * @param array $elements
     * @param callable $predicate
     * @return bool
     */
    public static function all(array $elements, $predicate)
    {
        foreach ($elements as $element) {
            if (!Functions::call($predicate, $element)) {
                return false;
            }
        }
        return true;
    }

    /**
     * This method creates associative array using key and value functions on array elements.
     *
     * Example:
     * <code>
     * $array = range(1, 2);
     * $map = Arrays::toMap($array, function ($elem) {
     *      return $elem * 10;
     * }, function ($elem) {
     *      return $elem + 1;
     * });
     * </code>
     * Result:
     * <code>
     * Array
     * (
     *      [10] => 2
     *      [20] => 3
     * )
     * </code>
     *
     * @param array $elements
     * @param callable $keyFunction
     * @param callable|null $valueFunction
     * @return array
     */
    public static function toMap(array $elements, $keyFunction, $valueFunction = null)
    {
        if ($valueFunction == null) {
            $valueFunction = Functions::identity();
        }

        $keys = array_map($keyFunction, $elements);
        $values = array_map($valueFunction, $elements);
        return empty($keys) ? array() : array_combine($keys, $values);
    }

    /**
     * Returns a new array that is a one-dimensional flattening of the given array.
     *
     * Example:
     * <code>
     * $array = array(
     *      'names' => array(
     *          'john',
     *          'peter',
     *          'bill'
     *      ),
     *      'products' => array(
     *          'cheese',
     *          array(
     *              'natural' => 'milk',
     *              'brie'
     *          )
     *      )
     * );
     * $flatten = Arrays::flatten($array);
     * </code>
     * Result:
     * <code>
     * Array
     * (
     *      [0] => john
     *      [1] => peter
     *      [2] => bill
     *      [3] => cheese
     *      [4] => milk
     *      [5] => brie
     * )
     * </code>
     *
     * @param array $array
     * @return array
     */
    public static function flatten(array $array)
    {
        $return = array();
        array_walk_recursive($array, function ($a) use (&$return) {
            $return[] = $a;
        });
        return $return;
    }

    /**
     * This method returns a key for the given value.
     *
     * Example:
     * <code>
     * $array = array(
     *      'k1' => 4,
     *      'k2' => 'd',
     *      'k3' => 0,
     *      9 => 'p'
     * );
     * $key = Arrays::findKeyByValue($array, 0);
     * </code>
     * Result:
     * <code>
     * k3
     * </code>
     *
     * @param array $elements
     * @param string $value
     * @return bool|int|string
     */
    public static function findKeyByValue(array $elements, $value)
    {
        if ($value === 0) {
            $value = '0';
        }
        foreach ($elements as $key => $item) {
            if ($item == $value) {
                return $key;
            }
        }
        return false;
    }

    /**
     * Returns true if at least one element in the array satisfies the predicate.
     *
     * Example:
     * <code>
     * $array = array('a', true, 'c');
     * $any = Arrays::any($array, function ($element) {
     *      return is_bool($element);
     * });
     * </code>
     * Result:
     * <code>
     * true
     * </code>
     *
     * @param array $elements
     * @param callable $predicate
     * @return bool
     */
    public static function any(array $elements, $predicate)
    {
        foreach ($elements as $element) {
            if (Functions::call($predicate, $element)) {
                return true;
            }
        }
        return false;
    }

    /**
     * This method returns the first value in the given array.
     *
     * Example:
     * <code>
     * $array = array('one', 'two' 'three');
     * $first = Arrays::first($array);
     * </code>
     * Result:
     * <code>one</code>
     *
     * @param array $elements
     * @return mixed
     * @throws InvalidArgumentException
     */
    public static function first(array $elements)
    {
        if (empty($elements)) {
            throw new InvalidArgumentException('empty array');
        }
        $keys = array_keys($elements);
        return $elements[$keys[0]];
    }

    /**
     * This method returns the last value in the given array.
     *
     * Example:
     * <code>
     * $array = array('a', 'b', 'c');
     * $last = Arrays::last($array);
     * </code>
     * Result:
     * <code>c</code>
     *
     * @param array $elements
     * @return mixed
     * @throws InvalidArgumentException
     */
    public static function last(array $elements)
    {
        if (empty($elements)) {
            throw new InvalidArgumentException('empty array');
        }
        return end($elements);
    }

    /**
     * This method returns the first value or null if array is empty.
     *
     * Example:
     * <code>
     * $array = array();
     * $return = Arrays::firstOrNull($array);
     * </code>
     * Result:
     * <code>null</code>
     *
     * @param array $elements
     * @return mixed|null
     */
    public static function firstOrNull(array $elements)
    {
        return empty($elements) ? null : self::first($elements);
    }

    /**
     * Returns the element for the given key or a default value otherwise.
     *
     * Example:
     * <code>
     * $array = array('id' => 1, 'name' => 'john');
     * $value = Arrays::getValue($array, 'name');
     * </code>
     * Result:
     * <code>john</code>
     *
     * Example:
     * <code>
     * $array = array('id' => 1, 'name' => 'john');
     * $value = Arrays::getValue($array, 'surname', '--not found--');
     * </code>
     * Result:
     * <code>--not found--</code>
     *
     * @param array $elements
     * @param string|int $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public static function getValue(array $elements, $key, $default = null)
    {
        return isset($elements[$key]) ? $elements[$key] : $default;
    }

    /**
     * Returns an array containing only the given keys.
     *
     * Example:
     * <code>
     * $array = array('a' => 1, 'b' => 2, 'c' => 3);
     * $filtered = Arrays::filterByAllowedKeys($array, array('a', 'b'));
     * </code>
     * Result:
     * <code>
     * Array
     * (
     *      [a] => 1
     *      [b] => 2
     * )
     * </code>
     *
     * @param array $elements
     * @param array $allowedKeys
     * @return array
     */
    public static function filterByAllowedKeys(array $elements, array $allowedKeys)
    {
        return array_intersect_key($elements, array_flip($allowedKeys));
    }

    /**
     * Filters array by keys using the predicate.
     *
     * Example:
     * <code>
     * $array = array('a1' => 1, 'a2' => 2, 'c' => 3);
     * $filtered = Arrays::filterByKeys($array, function ($elem) {
     *      return $elem[0] == 'a';
     * });
     * </code>
     * Result:
     * <code>
     * Array
     * (
     *      [a1] => 1
     *      [b2] => 2
     * )
     * </code>
     *
     * @param array $elements
     * @param callable $predicate
     * @return array
     */
    public static function filterByKeys(array $elements, $predicate)
    {
        $allowedKeys = array_filter(array_keys($elements), $predicate);
        return self::filterByAllowedKeys($elements, $allowedKeys);
    }

    /**
     * Group elements in array by result of the given function. If $orderField is set grouped elements will be also sorted.
     *
     * Example:
     * <code>
     * $obj1 = new stdClass();
     * $obj1->name = 'a';
     * $obj1->description = '1';
     *
     * $obj2 = new stdClass();
     * $obj2->name = 'b';
     * $obj2->description = '2';
     *
     * $obj3 = new stdClass();
     * $obj3->name = 'b';
     * $obj3->description = '3';
     *
     * $array = array($obj1, $obj2, $obj3);
     * $grouped = Arrays::groupBy($array, Functions::extractField('name'));
     * </code>
     * Result:
     * <code>
     * Array
     * (
     *      [a] => Array
     *      (
     *          [0] => stdClass Object
     *          (
     *              [name] => a
     *              [description] => 1
     *          )
     *      )
     *      [b] => Array
     *      (
     *          [0] => stdClass Object
     *          (
     *              [name] => b
     *              [description] => 2
     *          )
     *          [1] => stdClass Object
     *          (
     *              [name] => b
     *              [description] => 3
     *          )
     *      )
     * )
     * </code>
     *
     * @param array $elements
     * @param callable $keyFunction
     * @param string|null $orderField
     * @return array
     */
    public static function groupBy(array $elements, $keyFunction, $orderField = null)
    {
        $map = array();
        if (!empty($orderField)) {
            $elements = self::orderBy($elements, $orderField);
        }
        foreach ($elements as $element) {
            $key = Functions::call($keyFunction, $element);
            $map[$key][] = $element;
        }
        return $map;
    }

    /**
     * This method sorts elements in array using order field.
     *
     * Example:
     * <code>
     * $obj1 = new stdClass();
     * $obj1->name = 'a';
     * $obj1->description = '1';
     *
     * $obj2 = new stdClass();
     * $obj2->name = 'c';
     * $obj2->description = '2';
     *
     * $obj3 = new stdClass();
     * $obj3->name = 'b';
     * $obj3->description = '3';
     *
     * $array = array($obj1, $obj2, $obj3);
     * $sorted = Arrays::orderBy($array, 'name');
     * </code>
     * Result:
     * <code>
     * Array
     * (
     *      [0] => stdClass Object
     *      (
     *          [name] => a
     *          [description] => 1
     *      )
     *      [1] => stdClass Object
     *      (
     *          [name] => b
     *          [description] => 3
     *      )
     *      [2] => stdClass Object
     *      (
     *          [name] => c
     *          [description] => 2
     *      )
     * )
     * </code>
     *
     * @param array $elements
     * @param string $orderField
     * @return array
     */
    public static function orderBy(array $elements, $orderField)
    {
        usort($elements, function ($a, $b) use ($orderField) {
            return $a->$orderField < $b->$orderField ? -1 : 1;
        });
        return $elements;
    }

    /**
     * This method maps array keys using the function.
     * Invokes the function for each key in the array. Creates a new array containing the keys returned by the function.
     *
     * Example:
     * <code>
     * $array = array(
     *      'k1' => 'v1',
     *      'k2' => 'v2',
     *      'k3' => 'v3'
     * );
     * $arrayWithNewKeys = Arrays::mapKeys($array, function ($key) {
     *      return 'new_' . $key;
     * });
     * </code>
     * Result:
     * <code>
     * Array
     * (
     *      [new_k1] => v1
     *      [new_k2] => v2
     *      [new_k3] => v3
     * )
     * </code>
     *
     * @param array $elements
     * @param callable $function
     * @return array
     */
    public static function mapKeys(array $elements, $function)
    {
        $newArray = array();
        foreach ($elements as $oldKey => $value) {
            $newKey = Functions::call($function, $oldKey);
            $newArray[$newKey] = $value;
        }
        return $newArray;
    }

    /**
     * This method maps array values using the function.
     * Invokes the function for each value in the array. Creates a new array containing the values returned by the function.
     *
     * Example:
     * <code>
     * $array = array('k1', 'k2', 'k3');
     * $result = Arrays::map($array, function ($value) {
     *      return 'new_' . $value;
     * });
     * </code>
     * Result:
     * <code>
     * Array
     * (
     *      [0] => new_k1
     *      [1] => new_k2
     *      [2] => new_k3
     * )
     * </code>
     *
     * @param array $elements
     * @param callable $function
     * @return array
     */
    public static function map(array $elements, $function)
    {
        return array_map($function, $elements);
    }

    /**
     * This method filters array using function. Result contains all elements for which function returns true.
     *
     * Example:
     * <code>
     * $array = array(1, 2, 3, 4);
     * $result = Arrays::filter($array, function ($value) {
     *      return $value > 2;
     * });
     * </code>
     * Result:
     * <code>
     * Array
     * (
     *      [2] => 3
     *      [3] => 4
     * )
     * </code>
     *
     * @param array $elements
     * @param callable $function
     * @return array
     */
    public static function filter(array $elements, $function)
    {
        return array_filter($elements, $function);
    }

    /**
     * This method filter array will remove all values that are blank.
     *
     * @param array $elements
     * @return array
     */
    public static function filterNotBlank(array $elements)
    {
        return array_filter($elements);
    }

    /**
     * Make array from element. Returns the given argument if it's already an array.
     *
     * Example:
     * <code>
     * $result = Arrays::toArray('test');
     * </code>
     * Result:
     * <code>
     * Array
     * (
     *      [0] => test
     * )
     * </code>
     *
     * @param mixed $element
     * @return array
     */
    public static function toArray($element)
    {
        return $element ? is_array($element) ? $element : array($element) : array();
    }

    /**
     * Returns a random element from the given array.
     *
     * Example:
     * <code>
     * $array = array('john', 'city', 'small');
     * $rand = Arrays::randElement($array);
     * </code>
     * Result: <i>rand element from array</i>
     *
     * @param array $elements
     * @return null
     */
    public static function randElement($elements)
    {
        return $elements ? $elements[array_rand($elements)] : null;
    }

    /**
     * Returns a new array with $keys as array keys and $values as array values.
     *
     * Example:
     * <code>
     * $keys = array('id', 'name', 'surname');
     * $values = array(1, 'john', 'smith');
     * $combined = Arrays::combine($keys, $values);
     * </code>
     * Result:
     * <code>
     * Array
     * (
     *      [id] => 1
     *      [name] => john
     *      [surname] => smith
     * )
     * </code>
     *
     * @param array $keys
     * @param array $values
     * @return array
     */
    public static function combine(array $keys, array $values)
    {
        if (!empty($keys) && !empty($values)) {
            return array_combine($keys, $values);
        }
        return array();
    }

    /**
     * Checks is key exists in an array.
     *
     * Example:
     * <code>
     * $array = array('id' => 1, 'name' => 'john');
     * $return = Arrays::keyExists($array, 'name');
     * </code>
     * Result:
     * <code>true</code>
     *
     * @param array $elements
     * @param string|int $key
     * @return bool
     */
    public static function keyExists(array $elements, $key)
    {
        return array_key_exists($key, $elements);
    }

    /**
     * Method to reduce an array elements to a string value.
     *
     * @param array $elements
     * @param callable $function
     * @return mixed
     */
    public static function reduce(array $elements, $function)
    {
        return array_reduce($elements, $function);
    }

    /**
     * Finds first element in array that is matched by function.
     * Returns null if element was not found.
     *
     * @param array $elements
     * @param callable $function
     * @return mixed
     */
    public static function find(array $elements, $function)
    {
        foreach ($elements as $element) {
            if ($function($element)) {
                return $element;
            }
        }
        return null;
    }

    /**
     * Computes the intersection of arrays.
     *
     * @param array $array1
     * @param array $array2
     * @return array
     */
    public static function intersect(array $array1, array $array2)
    {
        return array_intersect($array1, $array2);
    }

    /**
     * Setting nested value.
     *
     * Example:
     * <code>
     * $array = array();
     * Arrays::setNestedValue($array, array('1', '2', '3'), 'value');
     * </code>
     * Result:
     * <code>
     * Array
     * (
     *      [1] => Array
     *          (
     *              [2] => Array
     *                  (
     *                      [3] => value
     *                  )
     *          )
     * )
     * </code>
     *
     * @param array $array
     * @param array $keys
     * @param $value
     */
    public static function setNestedValue(array &$array, array $keys, $value)
    {
        $current = &$array;
        foreach ($keys as $key) {
            if (!isset($current[$key])) {
                $current[$key] = array();
            }
            $current = &$current[$key];
        }
        $current = $value;
    }

    /**
     * Returns a new array with is sorted using given comparator.
     * The comparator function must return an integer less than, equal to, or greater than zero if the first argument is considered to be respectively less than, equal to, or greater than the second.
     * To obtain comparator one may use <code>Comparator</code> class (for instance <code>Comparator::natural()</code> which yields ordering using comparison operators).
     *
     * Example:
     * <code>
     * class Foo
     * {
     *      private $value;
     *      function __construct($value)
     *      {
     *          $this->value = $value;
     *      }
     *      public function getValue()
     *      {
     *          return $this->value;
     *      }
     * }
     * $values = array(new Foo(1), new Foo(3), new Foo(2));
     * $sorted = Arrays::sort($values, Comparator::compareBy('getValue()'));
     * </code>
     * Result:
     * <code>
     * Array
     * (
     *      [0] =>  class Foo (1) {
     *                  private $value => int(1)
     *              }
     *      [1] =>  class Foo (1) {
     *                  private $value => int(2)
     *              }
     *      [2] =>  class Foo (1) {
     *                  private $value => int(3)
     *              }
     * )
     * </code>
     *
     * @param array $array
     * @param $comparator
     * @return array sorted according to the comparator
     * @throws InvalidArgumentException
     */
    public static function sort(array $array, $comparator)
    {
        usort($array, $comparator);
        return $array;
    }

    /**
     * Return nested value when found, otherwise return <i>null</i> value.
     *
     * Example:
     * <code>
     * $array = array('1' => array('2' => array('3' => 'value')));
     * $value = Arrays::getNestedValue($array, array('1', '2', '3'));
     * </code>
     * Result:
     * <code>
     * value
     * </code>
     *
     * @param array $array
     * @param array $keys
     * @return array|mixed|null
     */
    public static function getNestedValue(array $array, array $keys)
    {
        foreach ($keys as $key) {
            $array = self::getValue(self::toArray($array), $key);
            if (!$array) {
                return $array;
            }
        }
        return $array;
    }

    /**
     * @deprecated
     * @param array $array
     * @param array $keys
     */
    public static function removeNestedValue(array &$array, array $keys)
    {
        trigger_error('Use Arrays::removeNestedKey instead', E_USER_DEPRECATED);
        self::removeNestedKey($array, $keys);
    }

    /**
     * Removes nested keys in array.
     *
     * Example:
     * <code>
     * $array = array('1' => array('2' => array('3' => 'value')));$array = array('1' => array('2' => array('3' => 'value')));
     * Arrays::removeNestedKey($array, array('1', '2'));
     * </code>
     * Result:
     * <code>
     * Array
     * (
     *      [1] => Array
     *          (
     *          )
     * )
     * </code>
     *
     * @param array $array
     * @param array $keys
     */
    public static function removeNestedKey(array &$array, array $keys)
    {
        $key = array_shift($keys);
        if (count($keys) == 0) {
            unset($array[$key]);
        } else if ($array[$key] !== null) {
            self::removeNestedKey($array[$key], $keys);
        }
    }

    /**
     * Checks if array has nested key. It's possible to check array with null values using flag <i>Arrays::TREAT_NULL_AS_VALUE</i>.
     *
     * Example:
     * <code>
     * $array = array('1' => array('2' => array('3' => 'value')));
     * $value = Arrays::hasNestedKey($array, array('1', '2', '3'));
     * </code>
     * Result:
     * <code>
     * true
     * </code>
     *
     * Example with null values:
     * <code>
     * $array = array('1' => array('2' => array('3' => null)));
     * $value = Arrays::hasNestedKey($array, array('1', '2', '3'), Arrays::TREAT_NULL_AS_VALUE);
     * </code>
     * Result:
     * <code>
     * true
     * </code>
     *
     * @param array $array
     * @param array $keys
     * @param null $flags
     * @return bool
     */
    public static function hasNestedKey(array $array, array $keys, $flags = null)
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $array) || (!($flags & self::TREAT_NULL_AS_VALUE) && !isset($array[$key]))) {
                return false;
            }
            $array = self::getValue($array, $key);
        }
        return true;
    }

    /**
     * Returns maps of the flatten keys with corresponding values.
     *
     * Example:
     * <code>
     * $array = array(
     *      'customer' => array(
     *          'name' => 'Name',
     *          'phone' => '123456789'
     *      ),
     *      'other' => array(
     *          'ids_map' => array(
     *              '1qaz' => 'qaz',
     *              '2wsx' => 'wsx'
     *          ),
     *          'first' => array(
     *              'second' => array(
     *                  'third' => 'some value'
     *              )
     *          )
     *      )
     * );
     * $flatten = Arrays::flattenKeysRecursively($array)
     * </code>
     * Result:
     * <code>
     * Array
     * (
     *      [customer.name] => Name
     *      [customer.phone] => 123456789
     *      [other.ids_map.1qaz] => qaz
     *      [other.ids_map.2wsx] => wsx
     *      [other.first.second.third] => some value
     * )
     * </code>
     *
     * @param array $array
     * @return array
     */
    public static function flattenKeysRecursively(array $array)
    {
        $result = array();
        self::_flattenKeyRecursively($array, $result, '');
        return $result;
    }

    private static function _flattenKeyRecursively($array, &$result, $parentKey)
    {
        foreach ($array as $key => $value) {
            $itemKey = ($parentKey ? $parentKey . '.' : '') . $key;
            if (is_array($value)) {
                self::_flattenKeyRecursively($value, $result, $itemKey);
            } else {
                $result[$itemKey] = $value;
            }
        }
    }

    /**
     * Returns the number of elements for which the predicate returns true.
     *
     * Example:
     * <code>
     * $array = array(1, 2, 3);
     * $count = Arrays::count($array, function ($element) {
     *      return $element < 3;
     * });
     * </code>
     * Result:
     * <code>
     * 2
     * </code>
     *
     * @param array $elements
     * @param callable $predicate
     * @return int
     */
    public static function count(array $elements, $predicate)
    {
        $count = 0;
        foreach ($elements as $element) {
            if (Functions::call($predicate, $element)) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * This method maps array values using the function which takes key and value as parameters.
     * Invokes the function for each value in the array. Creates a new array containing the values returned by the function.
     *
     * Example:
     * <code>
     * $array = array('a' => '1', 'b' => '2', 'c' => '3');
     * $result = Arrays::mapEntries($array, function ($key, $value) {
     *      return $key . '_' . $value;
     * });
     * </code>
     * Result:
     * <code>
     * Array
     * (
     *      [a] => a_1
     *      [b] => b_2
     *      [c] => c_3
     * )
     * </code>
     *
     * @param array $elements
     * @param callable $function
     * @return array
     */
    public static function mapEntries(array $elements, $function)
    {
        $keys = array_keys($elements);
        $values = array_values($elements);
        return array_combine($keys, array_map($function, $keys, $values));
    }

    /**
     * Removes duplicate values from an array. It uses the given expression to extract value that is compared.
     *
     * Example:
     * <code>
     * $a = new stdClass();
     * $a->name = 'bob';
     *
     * $b = new stdClass();
     * $b->name = 'bob';
     *
     * $array = [$a, $b];
     * $result = Arrays::uniqueBy($array, 'name');
     * </code>
     * Result:
     * <code>
     * Array
     * (
     *      [0] => $b
     * )
     * </code>
     *
     * @param array $elements
     * @param $selector
     * @return array
     * @throws Exception
     */
    public static function uniqueBy(array $elements, $selector)
    {
        return array_values(self::toMap($elements, Functions::extractExpression($selector)));
    }
}
