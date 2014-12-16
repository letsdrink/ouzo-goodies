<?php
namespace Ouzo\Tests;

use Exception;

class CatchException
{

    static $exception;

    public static function when($object)
    {
        self::$exception = null;
        return new CatchExceptionObject($object);
    }

    public static function assertThat()
    {
        return new CatchExceptionAssert(self::$exception);
    }

    public static function get()
    {
        return self::$exception;
    }
}

class CatchExceptionObject
{
    private $object;

    public function __construct($object)
    {
        $this->object = $object;
    }

    public function __call($method, $args)
    {
        try {
            call_user_func_array(array($this->object, $method), $args);
        } catch (Exception $exception) {
            CatchException::$exception = $exception;
        }
    }
}

class CatchExceptionAssert
{
    private $exception;

    public function __construct($exception)
    {
        $this->exception = $exception;
    }

    public function isInstanceOf($exception)
    {
        AssertAdapter::assertInstanceOf($exception, $this->exception);
        return $this;
    }

    public function isEqualTo($exception)
    {
        AssertAdapter::assertEquals($exception, $this->exception);
        return $this;
    }

    public function notCaught()
    {
        AssertAdapter::assertNull($this->exception);
        return $this;
    }

    public function hasMessage($message)
    {
        if ($this->exception instanceof Exception) {
            AssertAdapter::assertEquals($message, $this->exception->getMessage());
        } else {
            AssertAdapter::fail('Message not contains in exceptions');
        }
        return $this;
    }
}
