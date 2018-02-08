<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests\Mock;

use PHPUnit\Framework\Assert;

class ZeroInteractionsVerifier
{
    /**
     * @param SimpleMock $mock
     * @return void
     * @throws \Exception
     */
    public static function verify($mock)
    {
        if (empty($mock->calledMethods)) {
            Assert::assertTrue(true);
        } else {
            Assert::fail("Expected zero interactions but got " . MethodCall::arrayToString($mock->calledMethods));
        }
    }
}
