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
    const EMPTY_STRING = '';

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
        return str_replace('_', '', ucwords($string, '_'));
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
        return mb_strtolower(preg_replace('/(?<!^|_)\p{Lu}/', '_$0', $string));
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
            return substr($string, mb_strlen($prefix));
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
            return mb_substr($string, 0, -mb_strlen($suffix));
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
        $string = is_int($string) ? "$string" : $string;
        $prefix = is_int($prefix) ? "$prefix" : $prefix;
        return is_string($string) && is_string($prefix) && mb_substr($string, 0, mb_strlen($prefix)) === $prefix;
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
        $string = is_int($string) ? "$string" : $string;
        $suffix = is_int($suffix) ? "$suffix" : $suffix;
        $suffixLength = mb_strlen($suffix);
        return is_string($string) && is_string($suffix) && mb_substr($string, -$suffixLength, $suffixLength) === $suffix;
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
        return mb_strtolower($string1) == mb_strtolower($string2);
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
     * @param string $toRemove
     * @return mixed
     */
    public static function remove($string, $toRemove)
    {
        $string = is_int($string) ? "$string" : $string;
        $toRemove = is_int($toRemove) ? "$toRemove" : $toRemove;
        if (is_null($string) || is_null($toRemove)) {
            return $string;
        }
        return str_replace($toRemove, '', $string);
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
        if (is_null($string)) {
            return null;
        }
        return $string . $suffix;
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
        if (is_null($string)) {
            return null;
        }
        return $prefix . $string;
    }

    /**
     * Adds suffix to the string, if string does not end with the suffix already.
     *
     * Example:
     * <code>
     * $string = 'Daenerys Targaryen';
     * $stringWithPrefix = Strings::appendMissingSuffix($string, ' Targaryen');
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
    public static function appendIfMissing($string, $suffix)
    {
        if (Strings::endsWith($string, $suffix)) {
            return $string;
        }
        return Strings::appendSuffix($string, $suffix);
    }

    /**
     * Adds prefix to the string, if string does not start with the prefix already.
     *
     * Example:
     * <code>
     * $string = 'Daenerys Targaryen';
     * $stringWithPrefix = Strings::appendMissingPrefix($string, 'Daenerys ');
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
    public static function prependIfMissing($string, $prefix)
    {
        if (Strings::startsWith($string, $prefix)) {
            return $string;
        }
        return Strings::appendPrefix($string, $prefix);
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
     * Alias for htmlspecialchars() with UTF-8 and flags ENT_COMPAT and ENT_SUBSTITUTE (ENT_IGNORE for php <= 5.3).
     *
     * @param string $text
     * @return string
     */
    public static function htmlEntities($text)
    {
        $flag = defined('ENT_SUBSTITUTE') ? ENT_SUBSTITUTE : ENT_IGNORE;
        return htmlspecialchars($text, ENT_COMPAT | $flag, 'UTF-8');
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
     * To whole word:
     * <code>
     * $result = Strings::abbreviate('ouzo is great', 6, true);
     * </code>
     * Result:
     * <code>
     * ouzo ...
     * </code>
     *
     * @param string $string
     * @param string $maxWidth
     * @param bool $toWholeWord
     * @return string
     */
    public static function abbreviate($string, $maxWidth, $toWholeWord = false)
    {
        $fullLength = mb_strlen($string);
        if ($fullLength <= $maxWidth) {
            return $string;
        }

        if ($toWholeWord) {
            $lastSpace = mb_strrpos($string, ' ', -($fullLength - $maxWidth) + 1);
            $maxWidth = $lastSpace ? $lastSpace+1 : $maxWidth;
        }
        return mb_substr($string, 0, $maxWidth) . '...';
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
        foreach ($params as $key => $value) {
            $string = preg_replace("/%{($key)}/", $value, $string);
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
        foreach ($params as $key => $value) {
            $string = preg_replace("/%{($key)}/", $value, $string);
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
        return mb_strpos($string, $substring) !== false;
    }

    /**
     * Checks if string contains the substring, ignoring the case of the letters in the strings.
     *
     * @param string $string
     * @param string $substring
     * @return bool
     */
    public static function containsIgnoreCase($string, $substring)
    {
        return self::contains(mb_strtolower($string), mb_strtolower($substring));
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
     * Gets the substring after the first occurrence of a separator. The separator is not returned.
     *
     * @param string $string
     * @param string $separator
     * @return string
     */
    public static function substringAfter($string, $separator)
    {
        $pos = mb_strpos($string, $separator);
        if ($pos === false) {
            return $string;
        }
        return mb_substr($string, $pos + 1, mb_strlen($string));
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
            return substr_replace($subject, $replace, $matches[0][$nth][1], mb_strlen($search));
        }
        return $subject;
    }

    /**
     * Removes accent from letters in string.
     *
     * Example:
     * <code>
     * $string = "śżźćółŹĘÀÁÂ";
     * </code>
     * Result:
     * <code>
     * 'szzcolZEAAA'
     * </code>
     *
     * @param string $string
     * @return string
     */
    public static function removeAccent($string)
    {
        if (false === preg_match('/[\x80-\xff]/', $string)) {
            return $string;
        }

        $chars = [
            // Decompositions for Latin-1 Supplement
            chr(195) . chr(128) => 'A', chr(195) . chr(129) => 'A',
            chr(195) . chr(130) => 'A', chr(195) . chr(131) => 'A',
            chr(195) . chr(132) => 'A', chr(195) . chr(133) => 'A',
            chr(195) . chr(135) => 'C', chr(195) . chr(136) => 'E',
            chr(195) . chr(137) => 'E', chr(195) . chr(138) => 'E',
            chr(195) . chr(139) => 'E', chr(195) . chr(140) => 'I',
            chr(195) . chr(141) => 'I', chr(195) . chr(142) => 'I',
            chr(195) . chr(143) => 'I', chr(195) . chr(145) => 'N',
            chr(195) . chr(146) => 'O', chr(195) . chr(147) => 'O',
            chr(195) . chr(148) => 'O', chr(195) . chr(149) => 'O',
            chr(195) . chr(150) => 'O', chr(195) . chr(153) => 'U',
            chr(195) . chr(154) => 'U', chr(195) . chr(155) => 'U',
            chr(195) . chr(156) => 'U', chr(195) . chr(157) => 'Y',
            chr(195) . chr(159) => 's', chr(195) . chr(160) => 'a',
            chr(195) . chr(161) => 'a', chr(195) . chr(162) => 'a',
            chr(195) . chr(163) => 'a', chr(195) . chr(164) => 'a',
            chr(195) . chr(165) => 'a', chr(195) . chr(167) => 'c',
            chr(195) . chr(168) => 'e', chr(195) . chr(169) => 'e',
            chr(195) . chr(170) => 'e', chr(195) . chr(171) => 'e',
            chr(195) . chr(172) => 'i', chr(195) . chr(173) => 'i',
            chr(195) . chr(174) => 'i', chr(195) . chr(175) => 'i',
            chr(195) . chr(177) => 'n', chr(195) . chr(178) => 'o',
            chr(195) . chr(179) => 'o', chr(195) . chr(180) => 'o',
            chr(195) . chr(181) => 'o', chr(195) . chr(182) => 'o',
            chr(195) . chr(182) => 'o', chr(195) . chr(185) => 'u',
            chr(195) . chr(186) => 'u', chr(195) . chr(187) => 'u',
            chr(195) . chr(188) => 'u', chr(195) . chr(189) => 'y',
            chr(195) . chr(191) => 'y',
            // Decompositions for Latin Extended-A
            chr(196) . chr(128) => 'A', chr(196) . chr(129) => 'a',
            chr(196) . chr(130) => 'A', chr(196) . chr(131) => 'a',
            chr(196) . chr(132) => 'A', chr(196) . chr(133) => 'a',
            chr(196) . chr(134) => 'C', chr(196) . chr(135) => 'c',
            chr(196) . chr(136) => 'C', chr(196) . chr(137) => 'c',
            chr(196) . chr(138) => 'C', chr(196) . chr(139) => 'c',
            chr(196) . chr(140) => 'C', chr(196) . chr(141) => 'c',
            chr(196) . chr(142) => 'D', chr(196) . chr(143) => 'd',
            chr(196) . chr(144) => 'D', chr(196) . chr(145) => 'd',
            chr(196) . chr(146) => 'E', chr(196) . chr(147) => 'e',
            chr(196) . chr(148) => 'E', chr(196) . chr(149) => 'e',
            chr(196) . chr(150) => 'E', chr(196) . chr(151) => 'e',
            chr(196) . chr(152) => 'E', chr(196) . chr(153) => 'e',
            chr(196) . chr(154) => 'E', chr(196) . chr(155) => 'e',
            chr(196) . chr(156) => 'G', chr(196) . chr(157) => 'g',
            chr(196) . chr(158) => 'G', chr(196) . chr(159) => 'g',
            chr(196) . chr(160) => 'G', chr(196) . chr(161) => 'g',
            chr(196) . chr(162) => 'G', chr(196) . chr(163) => 'g',
            chr(196) . chr(164) => 'H', chr(196) . chr(165) => 'h',
            chr(196) . chr(166) => 'H', chr(196) . chr(167) => 'h',
            chr(196) . chr(168) => 'I', chr(196) . chr(169) => 'i',
            chr(196) . chr(170) => 'I', chr(196) . chr(171) => 'i',
            chr(196) . chr(172) => 'I', chr(196) . chr(173) => 'i',
            chr(196) . chr(174) => 'I', chr(196) . chr(175) => 'i',
            chr(196) . chr(176) => 'I', chr(196) . chr(177) => 'i',
            chr(196) . chr(178) => 'IJ', chr(196) . chr(179) => 'ij',
            chr(196) . chr(180) => 'J', chr(196) . chr(181) => 'j',
            chr(196) . chr(182) => 'K', chr(196) . chr(183) => 'k',
            chr(196) . chr(184) => 'k', chr(196) . chr(185) => 'L',
            chr(196) . chr(186) => 'l', chr(196) . chr(187) => 'L',
            chr(196) . chr(188) => 'l', chr(196) . chr(189) => 'L',
            chr(196) . chr(190) => 'l', chr(196) . chr(191) => 'L',
            chr(197) . chr(128) => 'l', chr(197) . chr(129) => 'L',
            chr(197) . chr(130) => 'l', chr(197) . chr(131) => 'N',
            chr(197) . chr(132) => 'n', chr(197) . chr(133) => 'N',
            chr(197) . chr(134) => 'n', chr(197) . chr(135) => 'N',
            chr(197) . chr(136) => 'n', chr(197) . chr(137) => 'N',
            chr(197) . chr(138) => 'n', chr(197) . chr(139) => 'N',
            chr(197) . chr(140) => 'O', chr(197) . chr(141) => 'o',
            chr(197) . chr(142) => 'O', chr(197) . chr(143) => 'o',
            chr(197) . chr(144) => 'O', chr(197) . chr(145) => 'o',
            chr(197) . chr(146) => 'OE', chr(197) . chr(147) => 'oe',
            chr(197) . chr(148) => 'R', chr(197) . chr(149) => 'r',
            chr(197) . chr(150) => 'R', chr(197) . chr(151) => 'r',
            chr(197) . chr(152) => 'R', chr(197) . chr(153) => 'r',
            chr(197) . chr(154) => 'S', chr(197) . chr(155) => 's',
            chr(197) . chr(156) => 'S', chr(197) . chr(157) => 's',
            chr(197) . chr(158) => 'S', chr(197) . chr(159) => 's',
            chr(197) . chr(160) => 'S', chr(197) . chr(161) => 's',
            chr(197) . chr(162) => 'T', chr(197) . chr(163) => 't',
            chr(197) . chr(164) => 'T', chr(197) . chr(165) => 't',
            chr(197) . chr(166) => 'T', chr(197) . chr(167) => 't',
            chr(197) . chr(168) => 'U', chr(197) . chr(169) => 'u',
            chr(197) . chr(170) => 'U', chr(197) . chr(171) => 'u',
            chr(197) . chr(172) => 'U', chr(197) . chr(173) => 'u',
            chr(197) . chr(174) => 'U', chr(197) . chr(175) => 'u',
            chr(197) . chr(176) => 'U', chr(197) . chr(177) => 'u',
            chr(197) . chr(178) => 'U', chr(197) . chr(179) => 'u',
            chr(197) . chr(180) => 'W', chr(197) . chr(181) => 'w',
            chr(197) . chr(182) => 'Y', chr(197) . chr(183) => 'y',
            chr(197) . chr(184) => 'Y', chr(197) . chr(185) => 'Z',
            chr(197) . chr(186) => 'z', chr(197) . chr(187) => 'Z',
            chr(197) . chr(188) => 'z', chr(197) . chr(189) => 'Z',
            chr(197) . chr(190) => 'z', chr(197) . chr(191) => 's'
        ];
        return strtr($string, $chars);
    }

    /**
     * Uppercase first letter (multi-byte safe).
     *
     * Example:
     * <code>
     * $string = "łukasz";
     * </code>
     * Result:
     * <code>
     * 'Łukasz'
     * </code>
     *
     * @param string $string
     * @return string
     */
    public static function uppercaseFirst($string)
    {
        $first = mb_substr($string, 0, 1);
        return mb_strtoupper($first) . mb_substr($string, 1);
    }
}
