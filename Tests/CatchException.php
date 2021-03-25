<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
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
    public static ?Throwable $exception;

    public static function when(object $object): CatchExceptionObject
    {
        self::$exception = null;
        return new CatchExceptionObject($object);
    }

    public static function assertThat(): CatchExceptionAssert
    {
        return new CatchExceptionAssert(self::$exception);
    }

    public static function get(): ?Throwable
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
     * @param string $className
     * @param array $params
     * @return object|null
     */
    public static function inConstructor(string $className, array $params): ?object
    {
        try {
            $class = new ReflectionClass($className);
            return $class->newInstanceArgs($params);
        } catch (Exception $e) {
            self::$exception = $e;
        }
        return null;
    }
}
