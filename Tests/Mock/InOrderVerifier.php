<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests\Mock;

use PHPUnit_Framework_ExpectationFailedException;
use SebastianBergmann\Comparator\ComparisonFailure;

class InOrderVerifier
{
    /**
     * @var array
     */
    private $scope = array();
    /**
     * @var null|MethodCall
     */
    private $current = null;

    /**
     * @param $mock
     * @return $this
     */
    public function verify($mock)
    {
        if (!$this->scope) {
            $extractMock = Mock::extractMock($mock);
            $this->scope = $extractMock->_called_methods;
        }
        return $this;
    }

    public function __call($name, $arguments)
    {
        if ($this->wasCalledInOrder($name, $arguments)) {
            return $this;
        }
        $expected = MethodCall::newInstance($name, $arguments)->toString();
        $actual = $this->actualCalls();
        $this->fail('Method was not called in order', $expected, $actual);
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
     * @throws PHPUnit_Framework_ExpectationFailedException
     */
    private function fail($description, $expected, $actual)
    {
        throw new PHPUnit_Framework_ExpectationFailedException(
            $description,
            new ComparisonFailure($expected, $actual, $expected, $actual)
        );
    }
}
