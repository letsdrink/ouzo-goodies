<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests\Mock;

use Ouzo\Tests\AssertAdapter;

class ZeroInteractionsVerifier
{
    public static function verify($mock)
    {
        if (!empty($mock->_called_methods)) {
            AssertAdapter::fail("Expected zero interactions but got " . MethodCall::arrayToString($mock->_called_methods));
        }
    }
}
