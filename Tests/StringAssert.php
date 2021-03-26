<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests;

/**
 * Fluent string assertions inspired by java fest assertions
 *
 * Sample usage:
 * <code>
 *  Assert::thatString("Frodo")->startsWith("Fro")->endsWith("do")->contains("rod")->doesNotContain("fro")->hasSize(5);
 *  Assert::thatString("Frodo")->matches('/Fro\w+/');
 *  Assert::thatString("Frodo")->isEqualToIgnoringCase("frodo");
 *  Assert::thatString("Frodo")->isEqualTo("Frodo");
 *  Assert::thatString("Frodo")->isEqualNotTo("asd");
 * </code>
 */
class StringAssert
{
    private ?string $actual;

    private function __construct(?string $actual)
    {
        $this->actual = $actual;
    }

    public static function that(?string $actual): StringAssert
    {
        return new StringAssert($actual);
    }

    public function contains(string $substring): StringAssert
    {
        AssertAdapter::assertContains($substring, $this->actual);
        return $this;
    }

    public function doesNotContain(string $substring): StringAssert
    {
        AssertAdapter::assertNotContains($substring, $this->actual);
        return $this;
    }

    public function startsWith(string $prefix): StringAssert
    {
        AssertAdapter::assertStringStartsWith($prefix, $this->actual);
        return $this;
    }

    public function endsWith(string $postfix): StringAssert
    {
        AssertAdapter::assertStringEndsWith($postfix, $this->actual);
        return $this;
    }

    public function isEqualToIgnoringCase(?string $string): StringAssert
    {
        AssertAdapter::assertEqualsIgnoringCase($string, $this->actual, 'Failed asserting that two strings are equal ignoring case.');
        return $this;
    }

    public function isEqualTo(?string $string): StringAssert
    {
        AssertAdapter::assertEquals($string, $this->actual);
        return $this;
    }

    public function isNotEqualTo(?string $string): StringAssert
    {
        AssertAdapter::assertNotEquals($string, $this->actual);
        return $this;
    }

    public function matches(string $regex): StringAssert
    {
        AssertAdapter::assertRegExp($regex, $this->actual);
        return $this;
    }

    public function hasSize(int $length): StringAssert
    {
        AssertAdapter::assertEquals($length, mb_strlen($this->actual));
        return $this;
    }

    public function isNull(): StringAssert
    {
        AssertAdapter::assertNull($this->actual);
        return $this;
    }

    public function isNotNull(): StringAssert
    {
        AssertAdapter::assertNotNull($this->actual);
        return $this;
    }

    public function isEmpty(): StringAssert
    {
        AssertAdapter::assertEmpty($this->actual);
        return $this;
    }

    public function isNotEmpty(): StringAssert
    {
        AssertAdapter::assertNotEmpty($this->actual);
        return $this;
    }
}
