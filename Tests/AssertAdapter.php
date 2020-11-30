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
    /**
     * @param mixed $condition
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertTrue($condition, $message = '')
    {
        PHPUnit_Assert::assertTrue($condition, $message);
    }

    /**
     * @param mixed $condition
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertFalse($condition, $message = '')
    {
        PHPUnit_Assert::assertFalse($condition, $message);
    }

    /**
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertEquals($expected, $actual, $message = '')
    {
        PHPUnit_Assert::assertEquals($expected, $actual, $message);
    }

    /**
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertEqualsIgnoringCase($expected, $actual, $message = '')
    {
        PHPUnit_Assert::assertEqualsIgnoringCase($expected, $actual, $message);
    }

    /**
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertNotEquals($expected, $actual, $message = '')
    {
        PHPUnit_Assert::assertNotEquals($expected, $actual, $message);
    }

    /**
     * @param mixed $actual
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertNull($actual, $message = '')
    {
        PHPUnit_Assert::assertNull($actual, $message);
    }

    /**
     * @param mixed $actual
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertNotNull($actual, $message = '')
    {
        PHPUnit_Assert::assertNotNull($actual, $message);
    }

    /**
     * @param mixed $actual
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertEmpty($actual, $message = '')
    {
        PHPUnit_Assert::assertEmpty($actual, $message);
    }

    /**
     * @param mixed $actual
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertNotEmpty($actual, $message = '')
    {
        PHPUnit_Assert::assertNotEmpty($actual, $message);
    }

    /**
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertSame($expected, $actual, $message = '')
    {
        PHPUnit_Assert::assertSame($expected, $actual, $message);
    }

    /**
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertInstanceOf($expected, $actual, $message = '')
    {
        PHPUnit_Assert::assertInstanceOf($expected, $actual, $message);
    }

    /**
     * @param mixed $needle
     * @param mixed $haystack
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertContains($needle, $haystack, $message = '')
    {
        PHPUnit_Assert::assertStringContainsString($needle, $haystack, $message);
    }

    /**
     * @param mixed $needle
     * @param mixed $haystack
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertNotContains($needle, $haystack, $message = '')
    {
        PHPUnit_Assert::assertStringNotContainsString($needle, $haystack, $message);
    }

    /**
     * @param string $prefix
     * @param string $string
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertStringStartsWith($prefix, $string, $message = '')
    {
        PHPUnit_Assert::assertStringStartsWith($prefix, $string, $message);
    }

    /**
     * @param string $prefix
     * @param string $string
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertStringEndsWith($prefix, $string, $message = '')
    {
        PHPUnit_Assert::assertStringEndsWith($prefix, $string, $message);
    }

    /**
     * @param string $pattern
     * @param string $string
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertRegExp($pattern, $string, $message = '')
    {
        PHPUnit_Assert::assertMatchesRegularExpression($pattern, $string, $message);
    }

    /**
     * @param string $message
     * @return void
     */
    public static function fail($message = '')
    {
        PHPUnit_Assert::fail($message);
    }

    /**
     * @param string $description
     * @param mixed $expected
     * @param mixed $actual
     * @param string $expectedAsString
     * @param string $actualAsString
     * @return void
     */
    public static function failWithDiff($description, $expected, $actual, $expectedAsString, $actualAsString)
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
