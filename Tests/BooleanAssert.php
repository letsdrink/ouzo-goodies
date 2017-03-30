<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests;

class BooleanAssert
{
    /** @var mixed */
    private $actual;

    /**
     * @param mixed $actual
     */
    private function __construct($actual)
    {
        $this->actual = $actual;
    }

    /**
     * @param mixed $actual
     * @return BooleanAssert
     */
    public static function that($actual)
    {
        return new BooleanAssert($actual);
    }

    /**
     * @return void
     */
    public function isTrue()
    {
        AssertAdapter::assertTrue($this->actual);
    }

    /**
     * @return void
     */
    public function isFalse()
    {
        AssertAdapter::assertFalse($this->actual);
    }
}
