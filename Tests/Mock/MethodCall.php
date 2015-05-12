<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests\Mock;

use Ouzo\Utilities\Arrays;
use Ouzo\Utilities\Functions;
use Ouzo\Utilities\Joiner;

class MethodCall
{
    public $name;
    public $arguments;

    public function __construct($name, $arguments)
    {
        $this->name = $name;
        $this->arguments = $arguments;
    }

    public function toString()
    {
        return $this->name . '(' . Joiner::on(', ')->join(Arrays::map($this->arguments, Functions::toString())) . ')';
    }

    public function __toString()
    {
        return $this->toString();
    }

    public static function arrayToString($calls)
    {
        return Joiner::on(', ')->join(Arrays::map($calls, Functions::toString()));
    }

    public static function newInstance($name, $arguments)
    {
        return new MethodCall($name, $arguments);
    }

    public static function hasName($name)
    {
        return function ($callStub) use ($name) {
            return $callStub->name == $name;
        };
    }
}
