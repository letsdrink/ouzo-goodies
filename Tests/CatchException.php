<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests;

use Exception;

class CatchException
{
    /** @var Exception|null */
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
     * @return Exception
     */
    public static function get()
    {
        return self::$exception;
    }
}
