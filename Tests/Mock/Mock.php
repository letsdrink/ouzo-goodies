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
    /**
     * @param null|string $className
     * @return SimpleMock
     */
    public static function create($className = null)
    {
        return self::mock($className);
    }

    /**
     * @param null|string $className
     * @return null|SimpleMock
     */
    public static function mock($className = null)
    {
        $mock = new SimpleMock();
        if (!$className) {
            return $mock;
        }
        return DynamicProxy::newInstance($className, $mock);
    }

    /**
     * @param Mock|SimpleMock $mock
     * @return WhenBuilder
     */
    public static function when($mock)
    {
        return new WhenBuilder(self::extractMock($mock));
    }

    /**
     * @param Mock|SimpleMock $mock
     * @return Verifier
     */
    public static function verify($mock)
    {
        return new Verifier(self::extractMock($mock));
    }

    /**
     * @param Mock|SimpleMock $mock
     * @return void
     * @throws \Exception
     */
    public static function verifyZeroInteractions($mock)
    {
        ZeroInteractionsVerifier::verify(self::extractMock($mock));
    }

    /**
     * @param Closure $callback
     */
    public static function verifyInOrder($callback)
    {
        $inOrderVerifier = new InOrderVerifier();
        $callback($inOrderVerifier);
    }

    /**
     * @param SimpleMock|Mock $mock
     * @return mixed
     */
    public static function extractMock($mock)
    {
        if (is_null($mock)) {
            throw new InvalidArgumentException("Instance of class Mock or SimpleMock expected, null given");
        }

        if ($mock instanceof SimpleMock) {
            return $mock;
        }
        return DynamicProxy::extractMethodHandler($mock);
    }

    /**
     * @return AnyArgument
     */
    public static function any()
    {
        return new AnyArgument();
    }

    /**
     * @return AnyArgumentList
     */
    public static function anyArgList()
    {
        return new AnyArgumentList();
    }

    /**
     * @return FluentArgumentMatcher
     */
    public static function argThat()
    {
        return new FluentArgumentMatcher();
    }

    /**
     * @return ArgumentMatcher
     */
    public static function all()
    {
        return new AndArgumentMatcher(func_get_args());
    }
}
