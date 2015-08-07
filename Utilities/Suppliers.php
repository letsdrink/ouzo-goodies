<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

use Ouzo\Utilities\Supplier\ExpiringMemoizingSupplier;
use Ouzo\Utilities\Supplier\MemoizingSupplier;
use Ouzo\Utilities\Supplier\Supplier;

/**
 * Static utility methods returning suppliers.
 * @package Ouzo\Utilities
 */
class Suppliers
{
    /**
     * Returns a supplier which caches the callback result and returns that value on subsequent calls to <code>get()</code>.
     *
     * @param callable $function
     * @return Supplier
     */
    public static function memoize($function)
    {
        return new MemoizingSupplier($function);
    }

    /**
     * Returns a supplier which caches the callback result and removes the cached value after specified time.
     * Subsequent calls to <code>get()</code> return the cached value if expiration time has not passed.
     * Time is passed in seconds.
     *
     * @param callable $function
     * @param int $expireTime
     * @return Supplier
     */
    public static function memoizeWithExpiration($function, $expireTime = 3600)
    {
        return new ExpiringMemoizingSupplier($function, $expireTime);
    }
}
