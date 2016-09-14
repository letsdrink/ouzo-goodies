<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests;


class BooleanAssert
{
    private $_actual;

    private function __construct($actual)
    {
        $this->_actual = $actual;
    }

    public static function that($actual)
    {
        return new BooleanAssert($actual);
    }

    public function isTrue()
    {
        AssertAdapter::assertTrue($this->_actual);
    }

    public function isFalse()
    {
        AssertAdapter::assertFalse($this->_actual);
    }
}