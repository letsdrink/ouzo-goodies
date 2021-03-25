<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests\Mock;

use Closure;
use InvalidArgumentException;
use Ouzo\Utilities\DynamicProxy;

class Mock
{
    public static function create(string $className = null): MockInterface
    {
        return self::mock($className);
    }

    public static function mock(string $className = null): MockInterface
    {
        $mock = new SimpleMock();
        if (!$className) {
            return $mock;
        }
        return DynamicProxy::newInstance($className, $mock);
    }

    public static function when(MockInterface $mock): WhenBuilder
    {
        return new WhenBuilder(self::extractMock($mock));
    }

    public static function verify(MockInterface $mock): Verifier
    {
        return new Verifier(self::extractMock($mock));
    }

    public static function verifyZeroInteractions(MockInterface $mock): void
    {
        ZeroInteractionsVerifier::verify(self::extractMock($mock));
    }

    public static function verifyInOrder(Closure $callback): void
    {
        $inOrderVerifier = new InOrderVerifier();
        $callback($inOrderVerifier);
    }

    public static function extractMock(MockInterface $mock): MockInterface
    {
        if (is_null($mock)) {
            throw new InvalidArgumentException("Instance of class Mock or SimpleMock expected, null given");
        }

        if ($mock instanceof SimpleMock) {
            return $mock;
        }
        return DynamicProxy::extractMethodHandler($mock);
    }

    public static function any(): AnyArgument
    {
        return new AnyArgument();
    }

    public static function anyArgList(): AnyArgumentList
    {
        return new AnyArgumentList();
    }

    public static function argThat(): FluentArgumentMatcher
    {
        return new FluentArgumentMatcher();
    }

    public static function all(): ArgumentMatcher
    {
        return new AndArgumentMatcher(func_get_args());
    }
}
