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
    public static function safeDecode($string, $asArray = false)
    {
        if ($string === '' || $string === null) { // for PHP 7 compatibility
            $string = json_encode(null);
        }
        return json_decode($string, $asArray);
    }

    /**
     * Decodes a JSON string, or throws JsonDecodeException on failure
     *
     * @param string $string
     * @param bool $asArray
     * @return mixed
     * @throws JsonDecodeException
     */
    public static function decode($string, $asArray = false)
    {
        $decoded = self::safeDecode($string, $asArray);
        if (is_null($decoded) == false) {
            return $decoded;
        }
        $code = self::lastError();
        if ($code == JSON_ERROR_NONE) {
            return $decoded;
        }
        throw new JsonDecodeException(self::lastErrorMessage(), $code);
    }

    private static function lastErrorMessage()
    {
        if (function_exists('json_last_error_msg')) {
            return json_last_error_msg();
        }
        return 'Could not parse json';
    }

    /**
     * Returns the JSON representation of the $value
     *
     * @param array|\JsonSerializable $value
     * @return string
     */
    public static function encode($value)
    {
        return json_encode($value);
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
