<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

/**
 * Class StrSubstitutor
 * @package Ouzo\Utilities
 */
class StrSubstitutor
{
    private $_values;
    private $_default;

    /**
     * Creates a substitutor object that uses the given array for placeholders resolution.
     * Optionally, substitutor can use the $default when no value is found for a placeholder.
     *
     * @param array $values
     * @param null|string $default
     */
    public function __construct($values = [], $default = null)
    {
        $this->_values = $values;
        $this->_default = $default;
    }

    /**
     * Replaces placeholders {{PLACEHOLDER_NAME}} with their values.
     *
     * Example:
     * <code>
     * $strSubstitutor = new StrSubstitutor(array('NAME' => 'John', 'SURNAME' => 'Smith'));
     * $substituted = $strSubstitutor->replace('Hi, {{NAME}} {{SURNAME}}');
     * </code>
     * Result:
     * <code>
     * Hi, John Smith
     * </code>
     *
     * Example:
     * <code>
     * $strSubstitutor = new StrSubstitutor(array(), 'Unknown');
     * $substituted = $strSubstitutor->replace('Hi, {{NAME}}');
     * </code>
     * Result:
     * <code>
     * Hi, Unknown
     * </code>
     *
     * @param string $string
     * @return mixed
     */
    public function replace($string)
    {
        return preg_replace_callback('/\{\{(.+?)}}/u', [$this, '_replace_vars'], $string);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     * @param array $match
     * @return string
     */
    private function _replace_vars($match)
    {
        $matched = $match[0];
        $name = $match[1];
        $default = is_null($this->_default) ? $matched : $this->_default;
        return isset($this->_values[$name]) ? $this->_values[$name] : $default;
    }
}
