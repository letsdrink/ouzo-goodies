<?php
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
     * Create substitutor object, and define placeholders - values map for the replacements.
     * Substitutor can use default value for the replacements when not found value in the defined map.
     *
     * @param array $values
     * @param null|string $default
     */
    public function __construct($values = array(), $default = null)
    {
        $this->_values = $values;
        $this->_default = $default;
    }

    /**
     * Replaces placeholders {{PLACEHOLDER_NAME}} for the defined value.
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
        return preg_replace_callback('/\{\{(\w+)}}/', array($this, '_replace_vars'), $string);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     */
    private function _replace_vars($match)
    {
        $matched = $match[0];
        $name = $match[1];
        $default = is_null($this->_default) ? $matched : $this->_default;
        return isset($this->_values[$name]) ? $this->_values[$name] : $default;
    }
}
