<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests\Mock;

use Ouzo\Utilities\Functions;

class WhenBuilder
{
    /** @var SimpleMock */
    private $mock;
    /** @var MethodCall */
    private $methodCall;

    /**
     * @param SimpleMock $mock
     */
    public function __construct(SimpleMock $mock)
    {
        $this->mock = $mock;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        $this->methodCall = new MethodCall($name, $arguments);
        return $this;
    }

    /**
     * @param array $results
     * @return $this
     */
    public function thenReturn(...$results)
    {
        foreach ($results as $result) {
            $this->mock->stubbedCalls[] = new CallStub($this->methodCall, Functions::constant($result));
        }
        return $this;
    }

    /**
     * @param mixed ...
     * @return $this
     */
    public function thenThrow($exception)
    {
        foreach (func_get_args() as $exception) {
            $this->mock->stubbedCalls[] = new CallStub($this->methodCall, Functions::throwException($exception));
        }
        return $this;
    }

    /**
     * @param array $callbacks
     * @return $this
     */
    public function thenAnswer(...$callbacks)
    {
        foreach ($callbacks as $callback) {
            $this->mock->stubbedCalls[] = new CallStub($this->methodCall, $callback);
        }
        return $this;
    }
}
