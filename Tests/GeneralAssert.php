<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests;

class GeneralAssert
{
    private mixed $actual;

    private function __construct(mixed $actual)
    {
        $this->actual = $actual;
    }

    public static function that(mixed $actual): GeneralAssert
    {
        return new GeneralAssert($actual);
    }

    public function isEqualTo(mixed $object): GeneralAssert
    {
        AssertAdapter::assertEquals($object, $this->actual);
        return $this;
    }

    public function isInstanceOf(string $className): GeneralAssert
    {
        AssertAdapter::assertInstanceOf($className, $this->actual);
        return $this;
    }

    public function isNull(): GeneralAssert
    {
        AssertAdapter::assertNull($this->actual);
        return $this;
    }
    
    public function isNotNull(): GeneralAssert
    {
        AssertAdapter::assertNotNull($this->actual);
        return $this;
    }
}
