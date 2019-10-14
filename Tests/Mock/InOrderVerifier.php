<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests\Mock;

use Ouzo\Tests\AssertAdapter;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\ExpectationFailedException;

class InOrderVerifier
{
    /** @var array */
    private $scope = [];
    /** @var null|MethodCall */
    private $current = null;

    /**
     * @param Mock|SimpleMock $mock
     * @return $this
     */
    public function verify($mock)
    {
        if (!$this->scope) {
            $extractMock = Mock::extractMock($mock);
            $this->scope = $extractMock->calledMethods;
        }
        return $this;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return $this
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        $wasCalledInOrder = $this->wasCalledInOrder($name, $arguments);
        if ($wasCalledInOrder) {
            Assert::assertTrue($wasCalledInOrder);
            return $this;
        } else {
            $expected = MethodCall::newInstance($name, $arguments)->toString();
            $actual = $this->actualCalls();
            Assert::assertEquals($expected, $actual, 'Method was not called in order');
        }
    }

    /**
     * @param string $name
     * @param mixed $arguments
     * @return bool
     */
    private function wasCalledInOrder($name, $arguments)
    {
        $this->current = array_shift($this->scope);
        if (!$this->current) {
            return false;
        }
        $methodCallMatcher = new MethodCallMatcher($name, $arguments);
        return $methodCallMatcher->matches($this->current);
    }

    /**
     * @return string
     */
    private function actualCalls()
    {
        return $this->current ? $this->current->toString() : 'no interactions';
    }

    /**
     * @param string $description
     * @param string $expected
     * @param string $actual
     * @throws ExpectationFailedException
     */
    private function fail($description, $expected, $actual)
    {
        AssertAdapter::failWithDiff($description,
            $expected,
            $actual,
            $expected,
            $actual
        );
    }
}
