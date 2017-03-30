<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

use ReflectionFunction;

/**
 * Class Cache
 * @package Ouzo\Utilities
 */
class Cache
{
    private static $_cache = [];

    /**
     * Caches the given closure using filename:line as a key.
     *
     * Example:
     * <code>
     * $countries = Cache::memoize(function() {{
     *    //expensive computation that returns a list of countries
     *    return Country:all();
     * })
     * </code>
     *
     * @param callable $function
     * @return mixed|null
     */
    public static function memoize($function)
    {
        $reflectionFunction = new ReflectionFunction($function);
        $key = "{$reflectionFunction->getFileName()}:{$reflectionFunction->getEndLine()}";
        return self::get($key, $function);
    }

    /**
     * Returns object from cache.
     * If there's no object for the given key and $functions is passed, $function result will be stored in cache under the given key.
     *
     * Example:
     * <code>
     * $countries = Cache::get("countries", function() {{
     *    //expensive computation that returns a list of countries
     *    return Country:all();
     * })
     * </code>
     *
     * @param string $key
     * @param callable|null $function
     * @return mixed|null
     */
    public static function get($key, $function = null)
    {
        if (!self::contains($key) && $function) {
            self::put($key, call_user_func($function));
        }
        return Arrays::getValue(self::$_cache, $key);
    }

    /**
     * @param string $key
     * @param callable $object
     * @return mixed
     */
    public static function put($key, $object)
    {
        return self::$_cache[$key] = $object;
    }

    /**
     * Checks if cache contains an object for the given key.
     *
     * @param string $key
     * @return bool
     */
    public static function contains($key)
    {
        return array_key_exists($key, self::$_cache);
    }

    /**
     * Returns number of stored objects.
     *
     * @return int
     */
    public static function size()
    {
        return count(self::$_cache);
    }

    /**
     * Clears all items stored in cache.
     *
     * @return void
     */
    public static function clear()
    {
        self::$_cache = [];
    }
}
