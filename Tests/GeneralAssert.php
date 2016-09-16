<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests;


class GeneralAssert
{
    private $_actual;

    private function __construct($actual)
    {
        $this->_actual = $actual;
    }

    public static function that($actual)
    {
        return new GeneralAssert($actual);
    }

    public function isEqualTo($object)
    {
        AssertAdapter::assertEquals($object, $this->_actual);
        return $this;
    }

    public function isInstanceOf($className)
    {
        AssertAdapter::assertInstanceOf($className, $this->_actual);
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
}