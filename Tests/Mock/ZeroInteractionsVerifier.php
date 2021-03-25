<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests\Mock;

use PHPUnit\Framework\Assert;

class ZeroInteractionsVerifier
{
    public static function verify(SimpleMock|Mock $mock): void
    {
        if (empty($mock->calledMethods)) {
            Assert::assertTrue(true);
        } else {
            Assert::fail("Expected zero interactions but got " . MethodCall::arrayToString($mock->calledMethods));
        }
    }
}
