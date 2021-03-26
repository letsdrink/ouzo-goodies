<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

use Ouzo\Utilities\Supplier\ExpiringMemoizingSupplier;
use Ouzo\Utilities\Supplier\MemoizingSupplier;

/**
 * Static utility methods returning suppliers.
 */
class Suppliers
{
    /** Returns a supplier which caches the callback result and returns that value on subsequent calls to <code>get()</code>. */
    public static function memoize(callable $function): MemoizingSupplier
    {
        return new MemoizingSupplier($function);
    }

    /**
     * Returns a supplier which caches the callback result and removes the cached value after specified time.
     * Subsequent calls to <code>get()</code> return the cached value if expiration time has not passed.
     * Time is passed in seconds.
     */
    public static function memoizeWithExpiration(callable $function, int $expireTime = 3600): ExpiringMemoizingSupplier
    {
        return new ExpiringMemoizingSupplier($function, $expireTime);
    }
}
