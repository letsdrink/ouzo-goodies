<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests;

use Throwable;

class CatchExceptionAssert
{
    private ?Throwable $exception;

    public function __construct(?Throwable $exception)
    {
        $this->exception = $exception;
    }

    public function isInstanceOf(string $exception): CatchExceptionAssert
    {
        AssertAdapter::assertTrue(class_exists($exception), "Cannot find expected exception class: $exception.");
        AssertAdapter::assertInstanceOf($exception, $this->exception);
        return $this;
    }

    public function isEqualTo(?Throwable $exception): CatchExceptionAssert
    {
        AssertAdapter::assertEquals($exception, $this->exception);
        return $this;
    }

    public function notCaught(): CatchExceptionAssert
    {
        AssertAdapter::assertEmpty($this->exception);
        return $this;
    }

    public function hasMessage(string $message): CatchExceptionAssert
    {
        $this->validateExceptionThrown();
        AssertAdapter::assertEquals($message, $this->exception->getMessage());
        return $this;
    }

    public function hasCode(int $code): CatchExceptionAssert
    {
        $this->validateExceptionThrown();
        AssertAdapter::assertEquals($code, $this->exception->getCode());
        return $this;
    }

    private function validateExceptionThrown(): void
    {
        if (!$this->exception) {
            AssertAdapter::fail('Exception was not thrown.');
        }
    }
}
