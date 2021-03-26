<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Validator;

class Validate
{
    public static function isTrue(bool $value, string $message = ''): bool
    {
        if ($value !== true) {
            throw new ValidateException($message);
        }
        return true;
    }

    public static function isEmail(string $value, string $message = ''): bool
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new ValidateException($message);
        }
        return true;
    }

    public static function isNotNull(mixed $value, string $message = ''): bool
    {
        if ($value === null) {
            throw new ValidateException($message);
        }
        return true;
    }
}
