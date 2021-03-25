<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

class Booleans
{
    public static function toBoolean(mixed $string): bool
    {
        if (is_numeric($string)) {
            return $string != 0;
        }
        return filter_var($string, FILTER_VALIDATE_BOOLEAN);
    }
}
