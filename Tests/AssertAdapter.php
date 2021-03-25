<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests;

use PHPUnit\Framework\Assert as PHPUnit_Assert;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\Comparator\ComparisonFailure;

class AssertAdapter
{
    public static function assertTrue(mixed $condition, string $message = ''): void
    {
        PHPUnit_Assert::assertTrue($condition, $message);
    }

    public static function assertFalse(mixed $condition, string $message = ''): void
    {
        PHPUnit_Assert::assertFalse($condition, $message);
    }

    public static function assertEquals(mixed $expected, mixed $actual, string $message = ''): void
    {
        PHPUnit_Assert::assertEquals($expected, $actual, $message);
    }

    public static function assertEqualsIgnoringCase(mixed $expected, mixed $actual, string $message = ''): void
    {
        PHPUnit_Assert::assertEqualsIgnoringCase($expected, $actual, $message);
    }

    public static function assertNotEquals(mixed $expected, mixed $actual, string $message = ''): void
    {
        PHPUnit_Assert::assertNotEquals($expected, $actual, $message);
    }

    public static function assertNull(mixed $actual, string $message = ''): void
    {
        PHPUnit_Assert::assertNull($actual, $message);
    }

    public static function assertNotNull(mixed $actual, string $message = ''): void
    {
        PHPUnit_Assert::assertNotNull($actual, $message);
    }

    public static function assertEmpty(mixed $actual, string $message = ''): void
    {
        PHPUnit_Assert::assertEmpty($actual, $message);
    }

    public static function assertNotEmpty(mixed $actual, string $message = ''): void
    {
        PHPUnit_Assert::assertNotEmpty($actual, $message);
    }

    public static function assertSame(mixed $expected, mixed $actual, string $message = ''): void
    {
        PHPUnit_Assert::assertSame($expected, $actual, $message);
    }

    public static function assertInstanceOf(mixed $expected, mixed $actual, string $message = ''): void
    {
        PHPUnit_Assert::assertInstanceOf($expected, $actual, $message);
    }

    public static function assertContains(mixed $needle, mixed $haystack, string $message = ''): void
    {
        PHPUnit_Assert::assertStringContainsString($needle, $haystack, $message);
    }

    public static function assertNotContains(mixed $needle, mixed $haystack, string $message = ''): void
    {
        PHPUnit_Assert::assertStringNotContainsString($needle, $haystack, $message);
    }

    public static function assertStringStartsWith(string $prefix, string $string, string $message = ''): void
    {
        PHPUnit_Assert::assertStringStartsWith($prefix, $string, $message);
    }

    public static function assertStringEndsWith(string $prefix, string $string, string $message = ''): void
    {
        PHPUnit_Assert::assertStringEndsWith($prefix, $string, $message);
    }

    public static function assertRegExp(string $pattern, string $string, string $message = ''): void
    {
        PHPUnit_Assert::assertMatchesRegularExpression($pattern, $string, $message);
    }

    public static function fail(string $message = ''): void
    {
        PHPUnit_Assert::fail($message);
    }
    
    public static function failWithDiff(string $description, mixed $expected, mixed $actual, string $expectedAsString, string $actualAsString): void
    {
        if (class_exists(ExpectationFailedException::class)) {
            throw new ExpectationFailedException(
                $description,
                new ComparisonFailure($expected, $actual, $expectedAsString, $actualAsString)
            );
        } else {
            throw new ExpectationFailedException(
                $description,
                new ComparisonFailure($expected, $actual, $expectedAsString, $actualAsString)
            );
        }

    }
}
