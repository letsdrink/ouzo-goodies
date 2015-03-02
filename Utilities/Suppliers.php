<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

class Suppliers
{

    public static function memoizeWithExpiration(callable $function, $expireTime = 3600)
    {
        return new ExpiringMemoizingSupplier($function, $expireTime);
    }
}