<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests\Mock;

use Ouzo\Tests\AssertAdapter;
use PHPUnit\Framework\Assert;

class InOrderVerifier
{
    private array $scope = [];
    private ?MethodCall $current = null;

    public function verify(Mock|SimpleMock|MockInterface $mock): InOrderVerifier
    {
        if (!$this->scope) {
            $extractMock = Mock::extractMock($mock);
            $this->scope = $extractMock->calledMethods;
        }
        return $this;
    }

    public function __call(string $name, array $arguments): InOrderVerifier
    {
        $wasCalledInOrder = $this->wasCalledInOrder($name, $arguments);
        if ($wasCalledInOrder) {
            Assert::assertTrue($wasCalledInOrder);
        } else {
            $expected = MethodCall::newInstance($name, $arguments)->toString();
            $actual = $this->actualCalls();
            Assert::assertEquals($expected, $actual, 'Method was not called in order');
        }
        return $this;
    }

    private function wasCalledInOrder(string $name, mixed $arguments): bool
    {
        $this->current = array_shift($this->scope);
        if (!$this->current) {
            return false;
        }
        $methodCallMatcher = new MethodCallMatcher($name, $arguments);
        return $methodCallMatcher->matches($this->current);
    }

    private function actualCalls(): string
    {
        return $this->current?->toString() ?? 'no interactions';
    }

    private function fail(string $description, string $expected, string $actual): void
    {
        AssertAdapter::failWithDiff($description,
            $expected,
            $actual,
            $expected,
            $actual
        );
    }
}
