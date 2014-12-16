<?php
namespace Ouzo\Utilities;

/**
 * Class Joiner
 * @package Ouzo\Utilities
 */
class Joiner
{
    private $_separator;
    private $_skipNulls;
    private $_function;
    private $_valuesFunction;

    public function __construct($separator)
    {
        $this->_separator = $separator;
    }

    /**
     * Return Joiner object and define separator for the linking elements.
     *
     * @param string $separator
     * @return Joiner
     */
    public static function on($separator)
    {
        return new Joiner($separator);
    }

    /**
     * Return joined string from the given array elements.
     *
     * @param array $array
     * @return string
     */
    public function join(array $array)
    {
        $function = $this->_function;
        $valuesFunction = $this->_valuesFunction;
        $result = '';
        foreach ($array as $key => $value) {
            if (!$this->_skipNulls || ($this->_skipNulls && $value)) {
                $result .= (
                    $function ? $function($key, $value) :
                        ($valuesFunction ? $valuesFunction($value) : $value)
                    ) . $this->_separator;
            }
        }
        return rtrim($result, $this->_separator);
    }

    /**
     * Sets flat which causes skipping null values.
     *
     * @return Joiner
     */
    public function skipNulls()
    {
        $this->_skipNulls = true;
        return $this;
    }

    /**
     * Call function on the each elements in array, passing to lambda key and value from the array.
     *
     * @param callable $function
     * @return Joiner
     */
    public function map($function)
    {
        $this->_function = $function;
        return $this;
    }

    /**
     * Call function on the each values of the array.
     *
     * @param callable $function
     * @return Joiner
     */
    public function mapValues($function)
    {
        $this->_valuesFunction = $function;
        return $this;
    }
}
