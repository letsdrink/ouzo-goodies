<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

/**
 * Class Strings
 * @package Ouzo\Utilities
 */
class Strings
{
    /**
     * Changes underscored string to the camel case.
     *
     * Example:
     * <code>
     * $string = 'lannisters_always_pay_their_debts';
     * $camelcase = Strings::underscoreToCamelCase($string);
     * </code>
     * Result:
     * <code>
     * LannistersAlwaysPayTheirDebts
     * </code>
     *
     * @param string $string
     * @return string
     */
    public static function underscoreToCamelCase($string)
    {
        $words = explode('_', $string);
        $return = '';
        foreach ($words as $word) {
            $return .= ucfirst(trim($word));
        }
        return $return;
    }

    /**
     * Changes camel case string to underscored.
     *
     * Example:
     * <code>
     * $string = 'LannistersAlwaysPayTheirDebts';
     * $underscored = Strings::camelCaseToUnderscore($string);
     * </code>
     * Result:
     * <code>
     * lannisters_always_pay_their_debts
     * </code>
     *
     * @param string $string
     * @return string
     */
    public static function camelCaseToUnderscore($string)
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $string));
    }

    /**
     * Returns a new string without the given prefix.
     *
     * Example:
     * <code>
     * $string = 'prefixRest';
     * $withoutPrefix = Strings::removePrefix($string, 'prefix');
     * </code>
     * Result:
     * <code>
     * Rest
     * </code>
     *
     * @param string $string
     * @param string $prefix
     * @return string
     */
    public static function removePrefix($string, $prefix)
    {
        if (self::startsWith($string, $prefix)) {
            return substr($string, strlen($prefix));
        }
        return $string;
    }

    /**
     * Removes prefixes defined in array from string.
     *
     * Example:
     * <code>
     * $string = 'prefixRest';
     * $withoutPrefix = Strings::removePrefixes($string, array('pre', 'fix'));
     * </code>
     * Result:
     * <code>
     * Rest
     * </code>
     *
     * @param string $string
     * @param array $prefixes
     * @return mixed
     */
    public static function removePrefixes($string, array $prefixes)
    {
        return array_reduce($prefixes, function ($string, $prefix) {
            return Strings::removePrefix($string, $prefix);
        }, $string);
    }

    /**
     * Returns a new string without the given suffix.
     *
     * Example:
     * <code>
     * $string = 'JohnSnow';
     * $withoutSuffix = Strings::removeSuffix($string, 'Snow');
     * </code>
     * Result:
     * <code>
     * John
     * </code>
     *
     * @param string $string
     * @param string $suffix
     * @return string
     */
    public static function removeSuffix($string, $suffix)
    {
        if (self::endsWith($string, $suffix)) {
            return substr($string, 0, -strlen($suffix));
        }
        return $string;
    }

    /**
     * Method checks if string starts with $prefix.
     *
     * Example:
     * <code>
     * $string = 'prefixRest';
     * $result = Strings::startsWith($string, 'prefix');
     * </code>
     * Result:
     * <code>
     * true
     * </code>
     *
     * @param string $string
     * @param string $prefix
     * @return bool
     */
    public static function startsWith($string, $prefix)
    {
        return $string && $prefix && strpos($string, $prefix) === 0;
    }

    /**
     * Method checks if string ends with $suffix.
     *
     * Example:
     * <code>
     * $string = 'StringSuffix';
     * $result = Strings::endsWith($string, 'Suffix');
     * </code>
     * Result:
     * <code>
     * true
     * </code>
     *
     * @param string $string
     * @param string $suffix
     * @return bool
     */
    public static function endsWith($string, $suffix)
    {
        return $string && $suffix && substr($string, -strlen($suffix)) === $suffix;
    }

    /**
     * Determines whether two strings contain the same data, ignoring the case of the letters in the strings.
     *
     * Example:
     * <code>
     * $equal = Strings::equalsIgnoreCase('ABC123', 'abc123');
     * </code>
     * Result:
     * <code>
     * true
     * </code>
     *
     * @param string $string1
     * @param string $string2
     * @return bool
     */
    public static function equalsIgnoreCase($string1, $string2)
    {
        return strtolower($string1) == strtolower($string2);
    }

    /**
     * Removes all occurrences of a substring from string.
     *
     * Example:
     * <code>
     * $string = 'winter is coming???!!!';
     * $result = Strings::remove($string, '???');
     * </code>
     * Result:
     * <code>
     * winter is coming!!!
     * </code>
     *
     * @param string $string
     * @param string $stringToRemove
     * @return mixed
     */
    public static function remove($string, $stringToRemove)
    {
        return $string && $stringToRemove ? str_replace($stringToRemove, '', $string) : $string;
    }

    /**
     * Adds suffix to the string.
     *
     * Example:
     * <code>
     * $string = 'Daenerys';
     * $stringWithSuffix = Strings::appendSuffix($string, ' Targaryen');
     * </code>
     * Result:
     * <code>
     * Daenerys Targaryen
     * </code>
     *
     * @param string $string
     * @param string $suffix
     * @return string
     */
    public static function appendSuffix($string, $suffix = '')
    {
        return $string ? $string . $suffix : $string;
    }

    /**
     * Adds prefix to the string.
     *
     * Example:
     * <code>
     * $string = 'Targaryen';
     * $stringWithPrefix = Strings::appendPrefix($string, 'Daenerys ');
     * </code>
     * Result:
     * <code>
     * Daenerys Targaryen
     * </code>
     *
     * @param string $string
     * @param string $prefix
     * @return string
     */
    public static function appendPrefix($string, $prefix = '')
    {
        return $string ? $prefix . $string : $string;
    }

    /**
     * Converts a word into the format for an Ouzo table name. Converts 'ModelName' to 'model_names'.
     *
     * Example:
     * <code>
     * $class = "BigFoot";
     * $table = Strings::tableize($class);
     * </code>
     * Result:
     * <code>
     * BigFeet
     * </code>
     *
     * @param string $class
     * @return string
     */
    public static function tableize($class)
    {
        $underscored = Strings::camelCaseToUnderscore($class);
        $parts = explode('_', $underscored);
        $suffix = Inflector::pluralize(array_pop($parts));
        $parts[] = $suffix;
        return implode('_', $parts);
    }

    /**
     * Changes new lines to &lt;br&gt; and converts special characters to HTML entities.
     *
     * Example:
     * <code>
     * $string = "My name is <strong>Reek</strong> \nit rhymes with leek";
     * $escaped = Strings::escapeNewLines($string);
     * </code>
     * Result:
     * <code>
     * My name is &lt;strong&gt;Reek&lt;/strong&gt; <br />it rhymes with leek
     * </code>
     *
     * @param string $string
     * @return string
     */
    public static function escapeNewLines($string)
    {
        $string = htmlspecialchars($string);
        return nl2br($string);
    }

    /**
     * Alias for html_entity_decode() with UTF-8 and defined flag ENT_COMPAT.
     *
     * @param string $text
     * @return string
     */
    public static function htmlEntityDecode($text)
    {
        return html_entity_decode($text, ENT_COMPAT, 'UTF-8');
    }

    /**
     * Alias for htmlentities() with UTF-8 and flags ENT_COMPAT and ENT_SUBSTITUTE (ENT_IGNORE for php <= 5.3).
     *
     * @param string $text
     * @return string
     */
    public static function htmlEntities($text)
    {
        $flag = defined('ENT_SUBSTITUTE') ? ENT_SUBSTITUTE : ENT_IGNORE;
        $htmlentities = htmlentities($text, ENT_COMPAT | $flag, 'UTF-8');
        $htmlentities = str_replace(array('&Oacute;', '&oacute;'), array('Ó', 'ó'), $htmlentities);
        return $htmlentities;
    }

    /**
     * Method checks if string representations of two objects are equal.
     *
     * Example:
     * <code>
     * $result = Strings::equal('0123', 123);
     * </code>
     * Result:
     * <code>
     * false
     * </code>
     *
     * @param mixed $object1
     * @param mixed $object2
     * @return bool
     */
    public static function equal($object1, $object2)
    {
        return (string)$object1 === (string)$object2;
    }

    /**
     * Method checks if string is blank.
     *
     * Example:
     * <code>
     * $result = Strings::isBlank('0');
     * </code>
     * Result:
     * <code>
     * false
     * </code>
     *
     * @param string $string
     * @return bool
     */
    public static function isBlank($string)
    {
        return mb_strlen(trim($string)) == 0;
    }

    /**
     * Method checks if string is not blank.
     *
     * Example:
     * <code>
     * $result = Strings::isNotBlank('0');
     * </code>
     * Result:
     * <code>
     * true
     * </code>
     *
     * @param string $string
     * @return bool
     */
    public static function isNotBlank($string)
    {
        return !Strings::isBlank($string);
    }

    /**
     * Abbreviate - abbreviates a string using ellipsis.
     *
     * Example:
     * <code>
     * $result = Strings::abbreviate('ouzo is great', 5);
     * </code>
     * Result:
     * <code>
     * ouzo ...
     * </code>
     *
     * @param string $string
     * @param string $maxWidth
     * @return string
     */
    public static function abbreviate($string, $maxWidth)
    {
        if (mb_strlen($string) > $maxWidth) {
            return mb_substr($string, 0, $maxWidth) . '...';
        }
        return $string;
    }


    /**
     * Removes control characters from both ends of this string returning null if the string is empty ("") after the trim or if it is null.
     *
     * Example:
     * <code>
     * $result = Strings::trimToNull('  ');
     * </code>
     * Result:
     * <code>
     * null
     * </code>
     *
     * @param string $string
     * @return string
     */
    public static function trimToNull($string)
    {
        $string = trim($string);
        if (mb_strlen($string) == 0) {
            return null;
        }
        return $string;
    }

    /**
     * Replace all occurrences of placeholder in string with values from associative array.
     *
     * Example:
     * <code>
     * $sprintfString = "This is %{what}! %{what}? This is %{place}!";
     * $assocArray = array(
     *   'what' => 'madness',
     *   'place' => 'Sparta'
     * );
     * </code>
     * Result:
     * <code>
     * 'This is madness! madness? This is Sparta!'
     * </code>
     *
     * @param string $string
     * @param array $params
     * @return string
     */
    public static function sprintAssoc($string, $params)
    {
        foreach ($params as $k => $v) {
            $string = preg_replace("/%{($k)}/", $v, $string);
        }
        return $string;
    }

    /**
     * Replace all occurrences of placeholder in string with values from associative array.
     * When no value for placeholder is found in array, a default empty value is used if not otherwise specified.
     *
     * Example:
     * <code>
     * $sprintfString = "This is %{what}! %{what}? This is %{place}!";
     * $assocArray = array(
     *   'what' => 'madness',
     *   'place' => 'Sparta'
     * );
     * </code>
     * Result:
     * <code>
     * 'This is madness! madness? This is Sparta!'
     * </code>
     *
     * @param string $string
     * @param array $params
     * @param string $default
     * @return string
     */
    public static function sprintAssocDefault($string, $params, $default = '')
    {
        foreach ($params as $k => $v) {
            $string = preg_replace("/%{($k)}/", $v, $string);
        }
        $string = preg_replace("/%{\w*}/", $default, $string);
        return $string;
    }

    /**
     * Checks if string contains the substring.
     *
     * @param string $string
     * @param string $substring
     * @return bool
     */
    public static function contains($string, $substring)
    {
        return strstr($string, $substring) !== false;
    }

    /**
     * Gets the substring before the first occurrence of a separator. The separator is not returned.
     *
     * @param string $string
     * @param string $separator
     * @return string
     */
    public static function substringBefore($string, $separator)
    {
        $pos = mb_strpos($string, $separator);
        return $pos !== false ? mb_substr($string, 0, $pos) : $string;
    }

    /**
     * @param string $subject
     * @param string $search
     * @param string $replace
     * @param int $nth
     * @return string
     */
    public static function replaceNth($subject, $search, $replace, $nth)
    {
        $found = preg_match_all('/' . $search . '/', $subject, $matches, PREG_OFFSET_CAPTURE);
        if (false !== $found && $found > $nth) {
            return substr_replace($subject, $replace, $matches[0][$nth][1], strlen($search));
        }
        return $subject;
    }
}
