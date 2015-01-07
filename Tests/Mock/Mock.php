<?php
namespace Ouzo\Tests\Mock;

use Ouzo\Utilities\DynamicProxy;

class Mock
{
    public static function create($className = null)
    {
        return self::mock($className);
    }

    public static function mock($className = null)
    {
        $mock = new SimpleMock();
        if (!$className) {
            return $mock;
        }
        return DynamicProxy::newInstance($className, $mock);
    }

    public static function when($mock)
    {
        return new WhenBuilder(self::_extractMock($mock));
    }

    public static function verify($mock)
    {
        return new Verifier(self::_extractMock($mock));
    }

    private static function _extractMock($mock)
    {
        if ($mock instanceof SimpleMock) {
            return $mock;
        }
        return DynamicProxy::extractMethodHandler($mock);
    }

    public static function any()
    {
        return new AnyArgument();
    }

    public static function anyArgList()
    {
        return new AnyArgumentList();
    }

    public static function argThat()
    {
        return new FluentArgumentMatcher();
    }
}
