<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

use Closure;
use Exception;
use Ouzo\Model;

class Functions
{
    public static function extractId(): Closure
    {
        return fn(Model $model) => $model->getId();
    }

    public static function extractField(string $name, bool $accessPrivate = false): Closure
    {
        return fn($object) => Objects::getValue($object, $name, null, $accessPrivate);
    }

    public static function extractFieldRecursively(string $names, bool $accessPrivate = false): Closure
    {
        return fn($object) => Objects::getValueRecursively($object, $names, null, $accessPrivate);
    }

    public static function extractExpression(string|Extractor|callable $selector, bool $accessPrivate = false): Closure|Extractor
    {
        if (!is_string($selector)) {
            return $selector;
        }
        if (str_contains($selector, '()') || str_contains($selector, '->')) {
            return Functions::extractFieldRecursively($selector, $accessPrivate);
        }
        return Functions::extractField($selector, $accessPrivate);
    }

    public static function identity(): Closure
    {
        return fn($object) => $object;
    }

    public static function constant(mixed $value): Closure
    {
        return fn() => $value;
    }

    public static function random(int $min = 0, ?int $max = null): Closure
    {
        return fn() => mt_rand($min, $max);
    }

    public static function throwException(Exception $exception): Closure
    {
        return fn() => throw $exception;
    }

    public static function trim(): Closure
    {
        return fn($string) => trim($string);
    }

    public static function not(callable $predicate): Closure
    {
        return fn($object) => !$predicate($object);
    }

    public static function isArray(): Closure
    {
        return fn($object) => is_array($object);
    }

    public static function isInstanceOf(string $type): Closure
    {
        return fn($object) => $object instanceof $type;
    }

    public static function prepend(string $prefix): Closure
    {
        return fn($string) => "{$prefix}{$string}";
    }

    public static function append(string $suffix): Closure
    {
        return fn($string) => "{$string}{$suffix}";
    }

    public static function notEmpty(): Closure
    {
        return fn($object) => !empty($object);
    }

    public static function isEmpty(): Closure
    {
        return fn($object) => empty($object);
    }

    public static function notBlank(): Closure
    {
        return fn($string) => Strings::isNotBlank($string);
    }

    public static function isBlank(): Closure
    {
        return fn($string) => Strings::isBlank($string);
    }

    public static function notNull(): Closure
    {
        return fn($value) => !is_null($value);
    }

    public static function removePrefix(string $prefix): Closure
    {
        return fn($string) => Strings::removePrefix($string, $prefix);
    }

    public static function startsWith(string $prefix): Closure
    {
        return fn($string) => Strings::startsWith($string, $prefix);
    }

    public static function endsWith(string $suffix): Closure
    {
        return fn($string) => Strings::endsWith($string, $suffix);
    }

    public static function containsSubstring(string $substring): Closure
    {
        return fn($string) => Strings::contains($string, $substring);
    }

    public static function formatDateTime(?string $format = Date::DEFAULT_TIME_FORMAT): Closure
    {
        return fn($date) => Date::formatDateTime($date, $format);
    }

    public static function call(callable $function, mixed $argument = null)
    {
        return call_user_func($function, $argument);
    }

    /**
     * Returns the composition of two functions.
     * composition is defined as the function h such that h(a) == A(B(a)) for each a.
     */
    public static function compose(callable $functionA, callable $functionB): Closure
    {
        return fn($input) => Functions::call($functionA, Functions::call($functionB, $input));
    }

    public static function toString(): Closure
    {
        return fn($object) => Objects::toString($object);
    }

    /** $type is just a hint for dynamicReturnType plugin */
    public static function extract(mixed $type = null): NonCallableExtractor
    {
        return new NonCallableExtractor();
    }

    public static function surroundWith(string $character): Closure
    {
        return fn($string) => "{$character}{$string}{$character}";
    }

    public static function equals(mixed $object): Closure
    {
        return fn($value) => Objects::equal($value, $object);
    }

    public static function notEquals(mixed $object): Closure
    {
        return fn($value) => !Objects::equal($value, $object);
    }

    public static function containsAll(mixed $element): Closure
    {
        return fn($array) => Arrays::containsAll($array, $element);
    }

    public static function contains(mixed $element): Closure
    {
        return fn($array) => Arrays::contains($array, $element);
    }

    public static function inArray(array $array): Closure
    {
        return fn($value) => in_array($value, $array);
    }

    public static function notInArray(array $array): Closure
    {
        return fn($value) => !in_array($value, $array);
    }

    public static function equalsIgnoreCase(?string $string): Closure
    {
        return fn($value) => Strings::equalsIgnoreCase($value, $string);
    }
}
