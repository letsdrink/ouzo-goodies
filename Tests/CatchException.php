<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests;

use Exception;
use ReflectionClass;
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

    /**
     * <code>
     * //given
     * class Color {
     *  public function __construct($firstParam, $secondParam, $thirdParam){
     *      throw new Exception();
     *  }
     * }
     *
     * class ColorTest extends TestCase{
     *  public function testConstructor(){
     *      //given
     *      $params =["firstParam", ["secondParam"], 3];
     *
     *      //when
     *      CatchException::inConstructor(Color::class, $params);
     *
     *      //then
     *      CatchException::assertThat()->isInstanceOf(Exception::class);
     *  }
     * }
     * </code>
     * @param $className
     * @param array $params
     * @return object
     */
    public static function inConstructor($className, array $params)
    {
        try {
            $class = new ReflectionClass($className);
            return $class->newInstanceArgs($params);
        } catch (Exception $e) {
            self::$exception = $e;
        }
    }
}
