<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests;

use Throwable;

/**
 * Class CatchException can be used as alternative to try{...}catch(...){...} block in tests.
 * It can be used in presented way:
 *
 * class ThrowableClass{
 *      public function throwableMethod(){...}
 * }
 *
 * $throwableObject = new ThrowableClass();
 *
 * CatchException::when($throwableObject)->throwableMethod();
 *
 * CatchException::assertThat()->isInstanceOf(ThrowableClass::class);
 *
 * @package Ouzo\Tests
 */
class CatchException
{
    /** @var Throwable|null */
    public static $exception;

    /**
     * @param object $object
     * @return CatchExceptionObject
     */
    public static function when($object)
    {
        self::$exception = null;
        return new CatchExceptionObject($object);
    }

    /**
     * @return CatchExceptionAssert
     */
    public static function assertThat()
    {
        return new CatchExceptionAssert(self::$exception);
    }

    /**
     * @return Throwable
     */
    public static function get()
    {
        return self::$exception;
    }
}
