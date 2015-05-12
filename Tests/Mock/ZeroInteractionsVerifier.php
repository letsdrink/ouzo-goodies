<?php

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