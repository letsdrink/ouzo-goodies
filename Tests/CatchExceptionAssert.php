<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests;

use Throwable;

class CatchExceptionAssert
{
    /** @var Throwable */
    private $exception;

    /**
     * @param Throwable $exception
     */
    public function __construct($exception)
    {
        $this->exception = $exception;
    }

    /**
     * @param string $exception
     * @return $this
     * @throws \Exception
     */
    public function isInstanceOf($exception)
    {
        AssertAdapter::assertTrue(class_exists($exception), "Cannot find expected exception class: $exception.");
        AssertAdapter::assertInstanceOf($exception, $this->exception);
        return $this;
    }

    /**
     * @param string $exception
     * @return $this
     * @throws \Exception
     */
    public function isEqualTo($exception)
    {
        AssertAdapter::assertEquals($exception, $this->exception);
        return $this;
    }

    /**
     * @return $this
     * @throws Throwable
     */
    public function notCaught()
    {
        AssertAdapter::assertEmpty($this->exception);
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     * @throws \Exception
     */
    public function hasMessage($message)
    {
        $this->_validateExceptionThrown();
        AssertAdapter::assertEquals($message, $this->exception->getMessage());
        return $this;
    }

    /**
     * @param int $code
     * @return $this
     * @throws \Exception
     */
    public function hasCode($code)
    {
        $this->_validateExceptionThrown();
        AssertAdapter::assertEquals($code, $this->exception->getCode());
        return $this;
    }

    /**
     * @return void
     */
    private function _validateExceptionThrown()
    {
        if (!$this->exception) {
            AssertAdapter::fail('Exception was not thrown.');
        }
    }
}
