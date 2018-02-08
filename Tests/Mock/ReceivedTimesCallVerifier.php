<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests\Mock;

use PHPUnit\Framework\Assert;

class ReceivedTimesCallVerifier extends Verifier
{
    /** @var int */
    private $times;

    /**
     * @param SimpleMock $mock
     * @param int $times
     */
    public function __construct(SimpleMock $mock, $times)
    {
        parent::__construct($mock);
        $this->times = $times;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return $this
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if ($this->numberOfActualCalls($name, $arguments) === $this->times) {
            Assert::assertEquals($this->times, $this->numberOfActualCalls($name, $arguments));
            return $this;
        } else {
            $calls = $this->actualCalls();
            $expected = MethodCall::newInstance($name, $arguments)
                    ->toString() . ' is called ' . $this->times . ' times';
            Assert::assertEquals($expected, $calls, "Called method incorrect times");
        }
    }
}
