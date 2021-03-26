<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

use ReflectionFunction;

class Cache
{
    private static array $cache = [];

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
     */
    public static function memoize(callable $function): mixed
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
     */
    public static function get(string $key, ?callable $function = null): mixed
    {
        if (!self::contains($key) && $function) {
            self::put($key, call_user_func($function));
        }
        return Arrays::getValue(self::$cache, $key);
    }

    public static function put(string $key, mixed $object): mixed
    {
        return self::$cache[$key] = $object;
    }

    /** Checks if cache contains an object for the given key. */
    public static function contains(string $key): bool
    {
        return array_key_exists($key, self::$cache);
    }

    /** Returns number of stored objects. */
    public static function size(): int
    {
        return count(self::$cache);
    }

    /** Clears all items stored in cache. */
    public static function clear(): void
    {
        self::$cache = [];
    }
}
