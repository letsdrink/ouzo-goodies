<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests\Mock;

use Closure;
use Ouzo\Utilities\Arrays;
use Ouzo\Utilities\Functions;
use Ouzo\Utilities\Joiner;

class MethodCall
{
    /** @var string */
    public $name;
    /** @var array */
    public $arguments;

    /**
     * @param string $name
     * @param array $arguments
     */
    public function __construct($name, $arguments)
    {
        $this->name = $name;
        $this->arguments = $arguments;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->name . '(' . Joiner::on(', ')->join(Arrays::map($this->arguments, Functions::toString())) . ')';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @param MethodCall[] $calls
     * @return string
     */
    public static function arrayToString($calls)
    {
        return Joiner::on(', ')->join(Arrays::map($calls, Functions::toString()));
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return MethodCall
     */
    public static function newInstance($name, $arguments)
    {
        return new MethodCall($name, $arguments);
    }

    /**
     * @param string $name
     * @return Closure
     */
    public static function hasName($name)
    {
        return function ($callStub) use ($name) {
            return $callStub->name == $name;
        };
    }
}
