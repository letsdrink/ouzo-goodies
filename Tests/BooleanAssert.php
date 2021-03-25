<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests;

class BooleanAssert
{
    private mixed $actual;

    private function __construct(mixed $actual)
    {
        $this->actual = $actual;
    }

    public static function that(mixed $actual): BooleanAssert
    {
        return new BooleanAssert($actual);
    }

    public function isTrue(): void
    {
        AssertAdapter::assertTrue($this->actual);
    }

    public function isFalse(): void
    {
        AssertAdapter::assertFalse($this->actual);
    }
}
