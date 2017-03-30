<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests;

use Ouzo\Model;

/**
 * Class Assert
 * @package Ouzo\Tests
 */
class Assert
{
    /**
     * Fluent custom array assertion to simplify your tests.
     *
     * Sample usage:
     * <code>
     *  $animals = array('cat', 'dog', 'pig');
     *  Assert::thatArray($animals)->hasSize(3)->contains('cat');
     *  Assert::thatArray($animals)->containsOnly('pig', 'dog', 'cat');
     *  Assert::thatArray($animals)->containsExactly('cat', 'dog', 'pig');
     *  Assert::thatArray(array('id' => 123, 'name' => 'john'))->containsKeyAndValue(array('id' => 123));
     * </code>
     *
     * @param array $actual
     * @return ArrayAssert
     */
    public static function thatArray(array $actual)
    {
        return ArrayAssert::that($actual);
    }

    /**
     * Fluent custom model assertion to simplify your tests.
     *
     * Sample usage:
     * <code>
     *  Assert::thatModel(new User(['name' => 'bob']))->hasSameAttributesAs(new User(['name' => 'bob']));
     * </code>
     *
     * @param Model $actual
     * @return ModelAssert
     */
    public static function thatModel(Model $actual)
    {
        return ModelAssert::that($actual);
    }

    /**
     * Fluent custom session assertion to simplify your tests.
     *
     * Sample usage:
     * <code>
     *  Session::push('key1', 'key2', 'value1');
     *  Assert::thatSession()->hasSize(1)->contains('value1');
     * </code>
     *
     * @return ArrayAssert
     */
    public static function thatSession()
    {
        return ArrayAssert::that(isset($_SESSION) ? $_SESSION : []);
    }

    /**
     * Fluent custom string assertion to simplify your tests.
     *
     * Sample usage:
     * <code>
     *  Assert::thatString("Frodo")->startsWith("Fro")->endsWith("do")->contains("rod")->doesNotContain("fro")->hasSize(5)->matches('/Fro\w+/');
     * </code>
     *
     * @param string $string
     * @return StringAssert
     */
    public static function thatString($string)
    {
        return StringAssert::that($string);
    }

    /**
     * Fluent custom boolean assertion to simplify your tests.
     *
     * Sample usage:
     * <code>
     *  Assert::thatBool(isCool())->isTrue();
     * </code>
     *
     * @param string $string
     * @return BooleanAssert
     */
    public static function thatBool($string)
    {
        return BooleanAssert::that($string);
    }

    /**
     * Fluent custom primitives' and objects' assertion to simplify your tests.
     *
     * Sample usage:
     * <code>
     *  Assert::that($object)->isInstanceOf(Controller::class);
     * </code>
     *
     * @param mixed $subject
     * @return GeneralAssert
     */
    public static function that($subject)
    {
        return GeneralAssert::that($subject);
    }
}
