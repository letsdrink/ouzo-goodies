<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests\Mock;

use PHPUnit\Framework\Assert;

class ReceivedTimesCallVerifier extends Verifier
{
    private int $times;

    public function __construct(SimpleMock $mock, int $times)
    {
        parent::__construct($mock);
        $this->times = $times;
    }

    public function __call(string $name, array $arguments): ReceivedTimesCallVerifier
    {
        if ($this->numberOfActualCalls($name, $arguments) === $this->times) {
            Assert::assertEquals($this->times, $this->numberOfActualCalls($name, $arguments));
        } else {
            $calls = $this->actualCalls();
            $expected = MethodCall::newInstance($name, $arguments)
                    ->toString() . ' is called ' . $this->times . ' times';
            Assert::assertEquals($expected, $calls, "Called method incorrect times");
        }
        return $this;
    }
}
