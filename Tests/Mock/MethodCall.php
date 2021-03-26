<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests\Mock;

use Closure;
use Ouzo\Utilities\Arrays;
use Ouzo\Utilities\Functions;
use Ouzo\Utilities\Joiner;

class MethodCall
{
    public string $name;
    public array $arguments;

    public function __construct(string $name, array $arguments)
    {
        $this->name = $name;
        $this->arguments = $arguments;
    }

    public function toString(): string
    {
        return $this->name . '(' . Joiner::on(', ')->join(Arrays::map($this->arguments, Functions::toString())) . ')';
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    /** @param MethodCall[] $calls */
    public static function arrayToString(array $calls): string
    {
        return Joiner::on(', ')->join(Arrays::map($calls, Functions::toString()));
    }

    public static function newInstance(string $name, array $arguments): MethodCall
    {
        return new MethodCall($name, $arguments);
    }

    public static function hasName(string $name): Closure
    {
        return function ($callStub) use ($name) {
            return $callStub->name == $name;
        };
    }
}
