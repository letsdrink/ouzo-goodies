<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests\Mock;

use Ouzo\Utilities\Functions;

class WhenBuilder
{
    private $mock;
    private $methodCall;

    public function __construct(SimpleMock $mock)
    {
        $this->mock = $mock;
    }

    public function __call($name, $arguments)
    {
        $this->methodCall = new MethodCall($name, $arguments);
        return $this;
    }

    /**
     * @param mixed ...
     */
    public function thenReturn()
    {
        foreach (func_get_args() as $result) {
            $this->mock->_stubbed_calls[] = new CallStub($this->methodCall, Functions::constant($result));
        }
    }

    /**
     * @param mixed ...
     */
    public function thenThrow($exception)
    {
        foreach (func_get_args() as $exception) {
            $this->mock->_stubbed_calls[] = new CallStub($this->methodCall, Functions::throwException($exception));
        }
    }

    /**
     * @param mixed ...
     */
    public function thenAnswer()
    {
        foreach (func_get_args() as $callback) {
            $this->mock->_stubbed_calls[] = new CallStub($this->methodCall, $callback);
        }
    }
}
