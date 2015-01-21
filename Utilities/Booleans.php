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
     * @param $string
     * @return bool
     */
    public static function toBoolean($string)
    {
        if (is_bool($string)) {
            return $string;
        }
        $string = strtolower($string);
        $specials = array('true', 'on', 'yes');
        if (in_array($string, $specials)) {
            return true;
        }
        if (Strings::equal($string, 'false')) {
            return false;
        }
        return !is_string($string);
    }
}
