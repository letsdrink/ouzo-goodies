<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

/**
 * Class Booleans
 * @package Ouzo\Utilities
 */
class Booleans
{
    /**
     * @param mixed $string
     * @return bool
     */
    public static function toBoolean($string)
    {
        if (is_numeric($string)) {
            return $string != 0;
        }
        return filter_var($string, FILTER_VALIDATE_BOOLEAN);
    }
}
