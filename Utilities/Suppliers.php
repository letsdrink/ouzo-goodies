<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

use Ouzo\Utilities\Supplier\ExpiringMemoizingSupplier;
use Ouzo\Utilities\Supplier\MemoizingSupplier;

class Suppliers
{

    public static function memoize($function)
    {
        return new MemoizingSupplier($function);
    }

    public static function memoizeWithExpiration($function, $expireTime = 3600)
    {
        return new ExpiringMemoizingSupplier($function, $expireTime);
    }
}