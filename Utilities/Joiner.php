<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
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
     * Returns a Joiner object that uses the given separator.
     *
     * @param string $separator
     * @return Joiner
     */
    public static function on($separator)
    {
        return new Joiner($separator);
    }

    /**
     * Returns a string containing array elements joined using the previously configured separator.
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
     * Returns a Joiner that skips null elements.
     * @return Joiner
     */
    public function skipNulls()
    {
        $this->_skipNulls = true;
        return $this;
    }

    /**
     * Returns a Joiner that transforms array elements before joining.
     * $function is called with two parameters: key and value.
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
     * Returns a Joiner that transforms array values before joining.
     * $function is called with one parameter: value.
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
