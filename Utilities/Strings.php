<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

class Strings
{
    const EMPTY_STRING = '';

    /**
     * Example:
     * <code>
     * $string = 'lannisters_always_pay_their_debts';
     * $camelcase = Strings::underscoreToCamelCase($string);
     * </code>
     * Result:
     * <code>
     * LannistersAlwaysPayTheirDebts
     * </code>
     */
    public static function underscoreToCamelCase(?string $string): ?string
    {
        if (is_null($string)) {
            return null;
        }
        return str_replace('_', self::EMPTY_STRING, ucwords($string, '_'));
    }

    /**
     * Example:
     * <code>
     * $string = 'LannistersAlwaysPayTheirDebts';
     * $underscored = Strings::camelCaseToUnderscore($string);
     * </code>
     * Result:
     * <code>
     * lannisters_always_pay_their_debts
     * </code>
     */
    public static function camelCaseToUnderscore(?string $string): ?string
    {
        if (is_null($string)) {
            return null;
        }
        return mb_strtolower(preg_replace('/(?<!^|_)\p{Lu}/', '_$0', $string));
    }

    /**
     * Example:
     * <code>
     * $string = 'prefixRest';
     * $withoutPrefix = Strings::removePrefix($string, 'prefix');
     * </code>
     * Result:
     * <code>
     * Rest
     * </code>
     */
    public static function removePrefix(?string $string, ?string $prefix): ?string
    {
        if (is_null($string)) {
            return null;
        }
        if (is_null($prefix)) {
            return $string;
        }
        if (self::startsWith($string, $prefix)) {
            return substr($string, mb_strlen($prefix));
        }
        return $string;
    }

    /**
     * Example:
     * <code>
     * $string = 'prefixRest';
     * $withoutPrefix = Strings::removePrefixes($string, array('pre', 'fix'));
     * </code>
     * Result:
     * <code>
     * Rest
     * </code>
     */
    public static function removePrefixes(?string $string, ?array $prefixes): ?string
    {
        if (is_null($prefixes)) {
            return $string;
        }
        return array_reduce($prefixes, fn($string, $prefix) => Strings::removePrefix($string, $prefix), $string);
    }

    /**
     * Example:
     * <code>
     * $string = 'JohnSnow';
     * $withoutSuffix = Strings::removeSuffix($string, 'Snow');
     * </code>
     * Result:
     * <code>
     * John
     * </code>
     */
    public static function removeSuffix(?string $string, ?string $suffix): ?string
    {
        if (is_null($string)) {
            return null;
        }
        if (self::endsWith($string, $suffix)) {
            return mb_substr($string, 0, -mb_strlen($suffix));
        }
        return $string;
    }

    /**
     * Example:
     * <code>
     * $string = 'prefixRest';
     * $result = Strings::startsWith($string, 'prefix');
     * </code>
     * Result:
     * <code>
     * true
     * </code>
     */
    public static function startsWith(?string $string, ?string $prefix): bool
    {
        if (is_null($prefix)) {
            return false;
        }
        return str_starts_with($string, $prefix);
    }

    /**
     * Example:
     * <code>
     * $string = 'StringSuffix';
     * $result = Strings::endsWith($string, 'Suffix');
     * </code>
     * Result:
     * <code>
     * true
     * </code>
     */
    public static function endsWith(?string $string, ?string $suffix): bool
    {
        if (is_null($suffix)) {
            return false;
        }
        return str_ends_with($string, $suffix);
    }

    /**
     * Example:
     * <code>
     * $equal = Strings::equalsIgnoreCase('ABC123', 'abc123');
     * </code>
     * Result:
     * <code>
     * true
     * </code>
     */
    public static function equalsIgnoreCase(?string $string1, ?string $string2): bool
    {
        if ((is_null($string1) && !is_null($string2)) || (!is_null($string1) && is_null($string2))) {
            return false;
        }
        return mb_strtolower($string1) === mb_strtolower($string2);
    }

    /**
     * Example:
     * <code>
     * $string = 'winter is coming???!!!';
     * $result = Strings::remove($string, '???');
     * </code>
     * Result:
     * <code>
     * winter is coming!!!
     * </code>
     */
    public static function remove(?string $string, ?string $toRemove): ?string
    {
        if (is_null($string)) {
            return null;
        }
        return str_replace($toRemove, self::EMPTY_STRING, $string);
    }

    /**
     * Example:
     * <code>
     * $string = 'Daenerys';
     * $stringWithSuffix = Strings::appendSuffix($string, ' Targaryen');
     * </code>
     * Result:
     * <code>
     * Daenerys Targaryen
     * </code>
     */
    public static function appendSuffix(?string $string, ?string $suffix = ''): ?string
    {
        if (is_null($string)) {
            return null;
        }
        return "{$string}{$suffix}";
    }

    /**
     * Example:
     * <code>
     * $string = 'Targaryen';
     * $stringWithPrefix = Strings::appendPrefix($string, 'Daenerys ');
     * </code>
     * Result:
     * <code>
     * Daenerys Targaryen
     * </code>
     */
    public static function appendPrefix(?string $string, ?string $prefix = ''): ?string
    {
        if (is_null($string)) {
            return null;
        }
        return "{$prefix}{$string}";
    }

    /**
     * Example:
     * <code>
     * $string = 'Daenerys Targaryen';
     * $stringWithPrefix = Strings::appendMissingSuffix($string, ' Targaryen');
     * </code>
     * Result:
     * <code>
     * Daenerys Targaryen
     * </code>
     */
    public static function appendIfMissing(?string $string, ?string $suffix): ?string
    {
        if (Strings::endsWith($string, $suffix)) {
            return $string;
        }
        return Strings::appendSuffix($string, $suffix);
    }

    /**
     * Example:
     * <code>
     * $string = 'Daenerys Targaryen';
     * $stringWithPrefix = Strings::appendMissingPrefix($string, 'Daenerys ');
     * </code>
     * Result:
     * <code>
     * Daenerys Targaryen
     * </code>
     */
    public static function prependIfMissing(?string $string, ?string $prefix): ?string
    {
        if (Strings::startsWith($string, $prefix)) {
            return $string;
        }
        return Strings::appendPrefix($string, $prefix);
    }

    /**
     * Example:
     * <code>
     * $class = "BigFoot";
     * $table = Strings::tableize($class);
     * </code>
     * Result:
     * <code>
     * BigFeet
     * </code>
     */
    public static function tableize(?string $class): ?string
    {
        if (is_null($class)) {
            return null;
        }
        $underscored = Strings::camelCaseToUnderscore($class);
        $parts = explode('_', $underscored);
        $suffix = Inflector::pluralize(array_pop($parts));
        $parts[] = $suffix;
        return implode('_', $parts);
    }

    /**
     * Example:
     * <code>
     * $string = "My name is <strong>Reek</strong> \nit rhymes with leek";
     * $escaped = Strings::escapeNewLines($string);
     * </code>
     * Result:
     * <code>
     * My name is &lt;strong&gt;Reek&lt;/strong&gt; <br />it rhymes with leek
     * </code>
     */
    public static function escapeNewLines(?string $string): ?string
    {
        if (is_null($string)) {
            return null;
        }
        return nl2br(htmlspecialchars($string));
    }

    public static function htmlEntityDecode(?string $text): ?string
    {
        if (is_null($text)) {
            return null;
        }
        return html_entity_decode($text, ENT_COMPAT, 'UTF-8');
    }

    public static function htmlEntities(?string $text): ?string
    {
        if (is_null($text)) {
            return null;
        }
        $flag = defined('ENT_SUBSTITUTE') ? ENT_SUBSTITUTE : ENT_IGNORE;
        return htmlspecialchars($text, ENT_COMPAT | $flag, 'UTF-8');
    }

    /**
     * Example:
     * <code>
     * $result = Strings::equal('0123', 123);
     * </code>
     * Result:
     * <code>
     * false
     * </code>
     */
    public static function equal(mixed $object1, mixed $object2): bool
    {
        return (string)$object1 === (string)$object2;
    }

    /**
     * Example:
     * <code>
     * $result = Strings::isBlank('0');
     * </code>
     * Result:
     * <code>
     * false
     * </code>
     */
    public static function isBlank(?string $string): bool
    {
        return mb_strlen(trim($string)) == 0;
    }

    /**
     * Example:
     * <code>
     * $result = Strings::isNotBlank('0');
     * </code>
     * Result:
     * <code>
     * true
     * </code>
     */
    public static function isNotBlank(?string $string): bool
    {
        return !Strings::isBlank($string);
    }

    /**
     * Example:
     * <code>
     * $result = Strings::abbreviate('ouzo is great', 5);
     * </code>
     * Result:
     * <code>
     * ouzo ...
     * </code>
     */
    public static function abbreviate(?string $string, ?string $maxWidth): ?string
    {
        if (is_null($string)) {
            return null;
        }
        if (mb_strlen($string) > $maxWidth) {
            return mb_substr($string, 0, $maxWidth) . '...';
        }
        return $string;
    }

    /**
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
     * @return string|null
     */
    public static function trimToNull(?string $string): ?string
    {
        $string = trim($string);
        if (mb_strlen($string) == 0) {
            return null;
        }
        return $string;
    }

    /**
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
     */
    public static function sprintAssoc(string|array|null $string, ?array $params): array|string|null
    {
        if (is_null($string)) {
            return null;
        }
        if (is_null($params)) {
            return $string;
        }
        foreach ($params as $key => $value) {
            $string = preg_replace("/%{($key)}/", $value, $string);
        }
        return $string;
    }

    /**
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
     */
    public static function sprintAssocDefault(?string $string, ?array $params, ?string $default = ''): ?string
    {
        if (is_null($string)) {
            return null;
        }
        if (!is_null($params)) {
            foreach ($params as $key => $value) {
                $string = preg_replace("/%{($key)}/", $value, $string);
            }
        }
        if (!is_null($default)) {
            $string = preg_replace("/%{\w*}/", $default, $string);
        }
        return $string;
    }

    public static function contains(?string $string, ?string $substring): bool
    {
        if (is_null($string) || is_null($substring)) {
            return false;
        }
        return str_contains($string, $substring);
    }

    public static function containsIgnoreCase(?string $string, ?string $substring): bool
    {
        if (is_null($string) || is_null($substring)) {
            return false;
        }
        return self::contains(mb_strtolower($string), mb_strtolower($substring));
    }

    public static function substringBefore(?string $string, ?string $separator): ?string
    {
        if (is_null($separator)) {
            return $string;
        }
        $pos = mb_strpos($string, $separator);
        return $pos !== false ? mb_substr($string, 0, $pos) : $string;
    }

    public static function substringAfter(?string $string, ?string $separator): ?string
    {
        if (is_null($separator)) {
            return $string;
        }
        $pos = mb_strpos($string, $separator);
        if ($pos === false) {
            return $string;
        }
        return mb_substr($string, $pos + 1, mb_strlen($string));
    }

    public static function replaceNth(?string $subject, ?string $search, ?string $replace, int $nth): ?string
    {
        if (is_null($search)) {
            return $subject;
        }
        $found = preg_match_all('/' . $search . '/', $subject, $matches, PREG_OFFSET_CAPTURE);
        if (false !== $found && $found > $nth && !is_null($replace)) {
            return substr_replace($subject, $replace, $matches[0][$nth][1], mb_strlen($search));
        }
        return $subject;
    }

    public static function removeAccent(?string $string): ?string
    {
        if (is_null($string)) {
            return null;
        }

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
     * Example:
     * <code>
     * $string = "łukasz";
     * </code>
     * Result:
     * <code>
     * 'Łukasz'
     * </code>
     */
    public static function uppercaseFirst(?string $string): ?string
    {
        if (is_null($string)) {
            return null;
        }
        $first = mb_substr($string, 0, 1);
        return mb_strtoupper($first) . mb_substr($string, 1);
    }

    public static function defaultIfBlank(?string $string, ?string $default): ?string
    {
        return self::isBlank($string) ? $default : $string;
    }
}
