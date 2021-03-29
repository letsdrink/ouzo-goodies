<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

class Json
{
    /** Decodes a JSON string */
    public static function safeDecode(?string $string, bool $asArray = false): mixed
    {
        if ($string === '' || $string === null) { // for PHP 7 compatibility
            $string = json_encode(null);
        }
        return json_decode($string, $asArray);
    }

    /** Returns the JSON representation of the $value */
    public static function safeEncode(mixed $value): string|bool
    {
        return json_encode($value);
    }

    /** Decodes a JSON string, or throws JsonDecodeException on failure */
    public static function decode(?string $string, bool $asArray = false): mixed
    {
        $decoded = self::safeDecode($string, $asArray);
        if (!is_null($decoded)) {
            return $decoded;
        }
        $code = self::lastError();
        if ($code === JSON_ERROR_NONE) {
            return null;
        }
        throw new JsonDecodeException(self::lastErrorMessage(), self::lastError());
    }

    /** Decodes a JSON string to array, or throws JsonDecodeException on failure */
    public static function decodeToArray(?string $string): array
    {
        return self::decode($string, true) ?: [];
    }

    private static function lastErrorMessage(): bool|string
    {
        if (function_exists('json_last_error_msg')) {
            return json_last_error_msg();
        }
        return 'JSON input is malformed';
    }

    /** Returns the JSON representation of the $value */
    public static function encode(mixed $value): string
    {
        $encoded = self::safeEncode($value);
        $lastErrorCode = self::lastError();
        if ($lastErrorCode !== JSON_ERROR_NONE || $encoded === false) {
            throw new JsonEncodeException(self::lastErrorMessage(), $lastErrorCode);
        }
        return $encoded;
    }

    /** Returns a JSON error code for the last operation. */
    public static function lastError(): int
    {
        return json_last_error();
    }
}
