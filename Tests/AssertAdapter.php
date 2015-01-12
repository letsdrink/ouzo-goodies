<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests;

use PHPUnit_Framework_Assert;

class AssertAdapter
{
    public static function assertTrue($condition, $message = '')
    {
        PHPUnit_Framework_Assert::assertTrue($condition, $message);
    }

    public static function assertFalse($condition, $message = '')
    {
        PHPUnit_Framework_Assert::assertFalse($condition, $message);
    }

    public static function assertEquals($expected, $actual, $message = '')
    {
        PHPUnit_Framework_Assert::assertEquals($expected, $actual, $message);
    }

    public static function assertEqualsIgnoringCase($expected, $actual, $message = '')
    {
        PHPUnit_Framework_Assert::assertEquals($expected, $actual, $message, 0, 10, false, true);
    }

    public static function assertNotEquals($expected, $actual, $message = '')
    {
        PHPUnit_Framework_Assert::assertNotEquals($expected, $actual, $message);
    }

    public static function assertNull($actual, $message = '')
    {
        PHPUnit_Framework_Assert::assertNull($actual, $message);
    }

    public static function assertNotNull($actual, $message = '')
    {
        PHPUnit_Framework_Assert::assertNotNull($actual, $message);
    }

    public static function assertEmpty($actual, $message = '')
    {
        PHPUnit_Framework_Assert::assertEmpty($actual, $message);
    }

    public static function assertNotEmpty($actual, $message = '')
    {
        PHPUnit_Framework_Assert::assertNotEmpty($actual, $message);
    }

    public static function assertSame($expected, $actual, $message = '')
    {
        PHPUnit_Framework_Assert::assertSame($expected, $actual, $message);
    }

    public static function assertInstanceOf($expected, $actual, $message = '')
    {
        PHPUnit_Framework_Assert::assertInstanceOf($expected, $actual, $message);
    }

    public static function assertContains($needle, $haystack, $message = '')
    {
        PHPUnit_Framework_Assert::assertContains($needle, $haystack, $message);
    }

    public static function assertNotContains($needle, $haystack, $message = '')
    {
        PHPUnit_Framework_Assert::assertNotContains($needle, $haystack, $message);
    }

    public static function assertStringStartsWith($prefix, $string, $message = '')
    {
        PHPUnit_Framework_Assert::assertStringStartsWith($prefix, $string, $message);
    }

    public static function assertStringEndsWith($prefix, $string, $message = '')
    {
        PHPUnit_Framework_Assert::assertStringEndsWith($prefix, $string, $message);
    }

    public static function assertRegExp($pattern, $string, $message = '')
    {
        PHPUnit_Framework_Assert::assertRegExp($pattern, $string, $message);
    }

    public static function fail($message = '')
    {
        PHPUnit_Framework_Assert::fail($message);
    }
}
