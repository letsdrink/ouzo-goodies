<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities\Validator;

/**
 * Class Validate
 * @package Ouzo\Utilities\Validator
 */
class Validate
{
    /**
     * Checks if value is true, if not throws ValidateException with the given message.
     *
     * @param bool $value
     * @param string $message
     * @return bool
     * @throws ValidateException
     */
    public static function isTrue($value, $message = '')
    {
        if ($value !== true) {
            throw new ValidateException($message);
        }
        return true;
    }

    /**
     * Checks if value is a correct email address, otherwise throws ValidateException with the user given message.
     *
     * @param string $value
     * @param string $message
     * @return bool
     * @throws ValidateException
     */
    public static function isEmail($value, $message = '')
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new ValidateException($message);
        }
        return true;
    }

    /**
     * Checks if value is not null, otherwise throws ValidateException with the user given message.
     *
     * @param mixed $value
     * @param string $message
     * @return bool
     * @throws ValidateException
     */
    public static function isNotNull($value, $message = '')
    {
        if ($value === null) {
            throw new ValidateException($message);
        }
        return true;
    }
}
