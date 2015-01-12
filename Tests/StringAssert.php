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
    private $_actual;

    private function __construct($actual)
    {
        $this->_actual = $actual;
    }

    public static function that($actual)
    {
        return new StringAssert($actual);
    }

    public function contains($substring)
    {
        AssertAdapter::assertContains($substring, $this->_actual);
        return $this;
    }

    public function doesNotContain($substring)
    {
        AssertAdapter::assertNotContains($substring, $this->_actual);
        return $this;
    }

    public function startsWith($prefix)
    {
        AssertAdapter::assertStringStartsWith($prefix, $this->_actual);
        return $this;
    }

    public function endsWith($postfix)
    {
        AssertAdapter::assertStringEndsWith($postfix, $this->_actual);
        return $this;
    }

    public function isEqualToIgnoringCase($string)
    {
        AssertAdapter::assertEqualsIgnoringCase($string, $this->_actual, 'Failed asserting that two strings are equal ignoring case.');
        return $this;
    }

    public function isEqualTo($string)
    {
        AssertAdapter::assertEquals($string, $this->_actual);
        return $this;
    }

    public function isNotEqualTo($string)
    {
        AssertAdapter::assertNotEquals($string, $this->_actual);
        return $this;
    }

    public function matches($regex)
    {
        AssertAdapter::assertRegExp($regex, $this->_actual);
        return $this;
    }

    public function hasSize($length)
    {
        AssertAdapter::assertEquals($length, mb_strlen($this->_actual));
        return $this;
    }

    public function isNull()
    {
        AssertAdapter::assertNull($this->_actual);
        return $this;
    }

    public function isNotNull()
    {
        AssertAdapter::assertNotNull($this->_actual);
        return $this;
    }

    public function isEmpty()
    {
        AssertAdapter::assertEmpty($this->_actual);
        return $this;
    }

    public function isNotEmpty()
    {
        AssertAdapter::assertNotEmpty($this->_actual);
        return $this;
    }
}
