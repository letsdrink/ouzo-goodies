<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
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
    /** @var string */
    private $actual;

    /**
     * @param string $actual
     */
    private function __construct($actual)
    {
        $this->actual = $actual;
    }

    /**
     * @param string $actual
     * @return StringAssert
     */
    public static function that($actual)
    {
        return new StringAssert($actual);
    }

    /**
     * @param string $substring
     * @return $this
     */
    public function contains($substring)
    {
        AssertAdapter::assertContains($substring, $this->actual);
        return $this;
    }

    /**
     * @param string $substring
     * @return $this
     */
    public function doesNotContain($substring)
    {
        AssertAdapter::assertNotContains($substring, $this->actual);
        return $this;
    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function startsWith($prefix)
    {
        AssertAdapter::assertStringStartsWith($prefix, $this->actual);
        return $this;
    }

    /**
     * @param string $postfix
     * @return $this
     */
    public function endsWith($postfix)
    {
        AssertAdapter::assertStringEndsWith($postfix, $this->actual);
        return $this;
    }

    /**
     * @param string $string
     * @return $this
     */
    public function isEqualToIgnoringCase($string)
    {
        AssertAdapter::assertEqualsIgnoringCase($string, $this->actual, 'Failed asserting that two strings are equal ignoring case.');
        return $this;
    }

    /**
     * @param string $string
     * @return $this
     */
    public function isEqualTo($string)
    {
        AssertAdapter::assertEquals($string, $this->actual);
        return $this;
    }

    /**
     * @param string $string
     * @return $this
     */
    public function isNotEqualTo($string)
    {
        AssertAdapter::assertNotEquals($string, $this->actual);
        return $this;
    }

    /**
     * @param string $regex
     * @return $this
     */
    public function matches($regex)
    {
        AssertAdapter::assertRegExp($regex, $this->actual);
        return $this;
    }

    /**
     * @param int $length
     * @return $this
     */
    public function hasSize($length)
    {
        AssertAdapter::assertEquals($length, mb_strlen($this->actual));
        return $this;
    }

    /**
     * @return $this
     */
    public function isNull()
    {
        AssertAdapter::assertNull($this->actual);
        return $this;
    }

    /**
     * @return $this
     */
    public function isNotNull()
    {
        AssertAdapter::assertNotNull($this->actual);
        return $this;
    }

    /**
     * @return $this
     */
    public function isEmpty()
    {
        AssertAdapter::assertEmpty($this->actual);
        return $this;
    }

    /**
     * @return $this
     */
    public function isNotEmpty()
    {
        AssertAdapter::assertNotEmpty($this->actual);
        return $this;
    }
}
