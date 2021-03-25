<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests\Mock;

use Ouzo\Tests\AssertAdapter;
use Ouzo\Utilities\Arrays;
use PHPUnit\Framework\Assert;

class Verifier
{
    private SimpleMock $mock;

    public function __construct(SimpleMock $mock)
    {
        $this->mock = $mock;
    }

    public function neverReceived(): NotCalledVerifier
    {
        return new NotCalledVerifier($this->mock);
    }

    public function receivedTimes(int $times): ReceivedTimesCallVerifier
    {
        return new ReceivedTimesCallVerifier($this->mock, $times);
    }

    public function __call(string $name, array $arguments): Verifier
    {
        if ($this->wasCalled($name, $arguments)) {
            Assert::assertNotEmpty($this->wasCalled($name, $arguments));
        } else {
            $calls = $this->actualCalls();
            $expected = MethodCall::newInstance($name, $arguments)->__toString();
            Assert::assertEquals($expected, $calls, "Expected method was not called");
        }
        return $this;
    }

    protected function fail(string $description, mixed $expected, mixed $actual): void
    {
        AssertAdapter::failWithDiff($description,
            $expected,
            $actual,
            $expected,
            $actual
        );
    }

    protected function actualCalls(): string
    {
        if (empty($this->mock->calledMethods)) {
            return "no interactions";
        }
        return MethodCall::arrayToString($this->mock->calledMethods);
    }

    protected function wasCalled(string $name, array $arguments): ?MethodCall
    {
        return Arrays::find($this->mock->calledMethods, new MethodCallMatcher($name, $arguments));
    }

    protected function numberOfActualCalls(string $name, array $arguments): int
    {
        return count(Arrays::filter($this->mock->calledMethods, new MethodCallMatcher($name, $arguments)));
    }
}
