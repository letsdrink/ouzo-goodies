<?php
namespace Ouzo\Utilities\Validator;

/**
 * Class Validate
 * @package Ouzo\Utilities\Validator
 */
class Validate
{
    /**
     * Check is value is true, otherwise throw ValidateException with the user given message.
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
     * Check is value is correct email address, otherwise throw ValidateException with the user given message.
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
     * Check is value is not null, otherwise throw ValidateException with the user given message.
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
