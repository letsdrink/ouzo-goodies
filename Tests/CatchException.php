<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests;

use Exception;

class CatchException
{
    public static $exception;

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
    /**
     * @var Exception
     */
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
        if ($this->exception) {
            throw $this->exception;
        }
        return $this;
    }

    public function hasMessage($message)
    {
        $this->_validateExceptionThrown();
        AssertAdapter::assertEquals($message, $this->exception->getMessage());
        return $this;
    }

    public function hasCode($code)
    {
        $this->_validateExceptionThrown();
        AssertAdapter::assertEquals($code, $this->exception->getCode());
        return $this;
    }

    private function _validateExceptionThrown()
    {
        if (!$this->exception) {
            AssertAdapter::fail('Exception was not thrown.');
        }
    }
}
