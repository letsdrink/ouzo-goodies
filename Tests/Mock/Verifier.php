<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests\Mock;

use Ouzo\Tests\AssertAdapter;
use Ouzo\Utilities\Arrays;
use PHPUnit\Framework\Assert;

class Verifier
{
    /** @var SimpleMock */
    private $mock;

    /**
     * @param SimpleMock $mock
     */
    public function __construct(SimpleMock $mock)
    {
        $this->mock = $mock;
    }

    /**
     * @return NotCalledVerifier
     */
    public function neverReceived()
    {
        return new NotCalledVerifier($this->mock);
    }

    /**
     * @param int $times
     * @return ReceivedTimesCallVerifier
     */
    public function receivedTimes($times)
    {
        return new ReceivedTimesCallVerifier($this->mock, $times);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return $this
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if ($this->wasCalled($name, $arguments)) {
            Assert::assertNotEmpty($this->wasCalled($name, $arguments));
            return $this;
        } else {
            $calls = $this->actualCalls();
            $expected = MethodCall::newInstance($name, $arguments)->__toString();
            Assert::assertEquals($expected, $calls, "Expected method was not called");
//            $this->fail("Expected method was not called", $expected, $calls);
        }
    }

    /**
     * @param string $description
     * @param mixed $expected
     * @param mixed $actual
     * @return void
     */
    protected function fail($description, $expected, $actual)
    {
        AssertAdapter::failWithDiff($description,
            $expected,
            $actual,
            $expected,
            $actual
        );
    }

    /**
     * @return string
     */
    protected function actualCalls()
    {
        if (empty($this->mock->calledMethods)) {
            return "no interactions";
        }
        return MethodCall::arrayToString($this->mock->calledMethods);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return MethodCall
     */
    protected function wasCalled($name, $arguments)
    {
        return Arrays::find($this->mock->calledMethods, new MethodCallMatcher($name, $arguments));
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return int
     */
    protected function numberOfActualCalls($name, $arguments)
    {
        return count(Arrays::filter($this->mock->calledMethods, new MethodCallMatcher($name, $arguments)));
    }
}
