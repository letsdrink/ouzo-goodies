<?php
namespace Ouzo\Utilities;

/**
 * Class Json
 * @package Ouzo\Utilities
 */
class Json
{
    /**
     * Decodes string contains JSON.
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
     * Encode array to the JSON format.
     *
     * @param array $array
     * @return string
     */
    public static function encode($array)
    {
        return json_encode($array);
    }

    /**
     * Return JSON error code for the last JSON operation.
     *
     * @return int
     */
    public static function lastError()
    {
        return json_last_error();
    }
}
