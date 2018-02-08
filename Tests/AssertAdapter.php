<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests;

use PHPUnit\Framework\Assert;
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
        Assert::assertTrue($condition, $message);
    }

    /**
     * @param mixed $condition
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertFalse($condition, $message = '')
    {
        Assert::assertFalse($condition, $message);
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
        Assert::assertEquals($expected, $actual, $message);
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
        Assert::assertEquals($expected, $actual, $message, 0, 10, false, true);
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
        Assert::assertNotEquals($expected, $actual, $message);
    }

    /**
     * @param mixed $actual
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertNull($actual, $message = '')
    {
        Assert::assertNull($actual, $message);
    }

    /**
     * @param mixed $actual
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertNotNull($actual, $message = '')
    {
        Assert::assertNotNull($actual, $message);
    }

    /**
     * @param mixed $actual
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertEmpty($actual, $message = '')
    {
        Assert::assertEmpty($actual, $message);
    }

    /**
     * @param mixed $actual
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assertNotEmpty($actual, $message = '')
    {
        Assert::assertNotEmpty($actual, $message);
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
        Assert::assertSame($expected, $actual, $message);
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
        Assert::assertInstanceOf($expected, $actual, $message);
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
        Assert::assertContains($needle, $haystack, $message);
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
        Assert::assertNotContains($needle, $haystack, $message);
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
        Assert::assertStringStartsWith($prefix, $string, $message);
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
        Assert::assertStringEndsWith($prefix, $string, $message);
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
        Assert::assertRegExp($pattern, $string, $message);
    }

    /**
     * @param string $message
     * @return void
     */
    public static function fail($message = '')
    {
        Assert::fail($message);
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
        throw new ExpectationFailedException(
            $description,
            new ComparisonFailure($expected, $actual, $expectedAsString, $actualAsString)
        );
    }
}
