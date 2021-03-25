<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests\Mock;

use Ouzo\Utilities\Functions;

class WhenBuilder
{
    private MockInterface $mock;
    private MethodCall $methodCall;

    public function __construct(MockInterface $mock)
    {
        $this->mock = $mock;
    }

    public function __call(string $name, array $arguments): WhenBuilder
    {
        $this->methodCall = new MethodCall($name, $arguments);
        return $this;
    }

    public function thenReturn(...$results): WhenBuilder
    {
        foreach ($results as $result) {
            $this->mock->stubbedCalls[] = new CallStub($this->methodCall, Functions::constant($result));
        }
        return $this;
    }

    public function thenThrow(...$exceptions): WhenBuilder
    {
        foreach (func_get_args() as $exception) {
            $this->mock->stubbedCalls[] = new CallStub($this->methodCall, Functions::throwException($exception));
        }
        return $this;
    }

    public function thenAnswer(...$callbacks): WhenBuilder
    {
        foreach ($callbacks as $callback) {
            $this->mock->stubbedCalls[] = new CallStub($this->methodCall, $callback);
        }
        return $this;
    }
}
