<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

/**
 * Class Json
 * @package Ouzo\Utilities
 */
class Json
{
    /**
     * Decodes a JSON string
     *
     * @param string $string
     * @param bool $asArray
     * @return mixed
     */
    public static function decode($string, $asArray = false)
    {
        return json_decode($string, $asArray);
    }

    /**
     * Returns the JSON representation of the $array
     *
     * @param array $array
     * @return string
     */
    public static function encode($array)
    {
        return json_encode($array);
    }

    /**
     * Returns a JSON error code for the last operation.
     *
     * @return int
     */
    public static function lastError()
    {
        return json_last_error();
    }
}
