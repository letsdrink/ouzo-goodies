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
     * Returns the JSON representation of the $value
     *
     * @param mixed $value
     * @return string|false
     */
    public static function safeEncode($value)
    {
        return json_encode($value);
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
        if ($code === JSON_ERROR_NONE) {
            return $decoded;
        }
        throw new JsonDecodeException(self::lastErrorMessage(), $code);
    }

    /**
     * Decodes a JSON string to array, or throws JsonDecodeException on failure
     *
     * @param string $string
     * @return mixed
     * @throws JsonDecodeException
     */
    public static function decodeToArray($string)
    {
        return self::decode($string, true);
    }

    private static function lastErrorMessage()
    {
        if (function_exists('json_last_error_msg')) {
            return json_last_error_msg();
        }
        return 'JSON input is malformed';
    }

    /**
     * Returns the JSON representation of the $value
     *
     * @param null|bool|int|float|string|object|array|\JsonSerializable $value
     * @return string
     * @throws JsonEncodeException
     */
    public static function encode($value)
    {
        $encoded = self::safeEncode($value);
        $lastErrorCode = self::lastError();
        if ($lastErrorCode !== JSON_ERROR_NONE || $encoded === false) {
            throw new JsonEncodeException(self::lastErrorMessage(), $lastErrorCode);
        }
        return $encoded;
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
