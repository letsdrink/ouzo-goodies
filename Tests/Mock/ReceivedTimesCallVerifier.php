<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests\Mock;

class ReceivedTimesCallVerifier extends Verifier
{
    /** @var int */
    private $times;

    public function __construct(SimpleMock $mock, $times)
    {
        parent::__construct($mock);
        $this->times = $times;
    }

    public function __call($name, $arguments)
    {
        if ($this->numberOfActualCalls($name, $arguments) === $this->times) {
            return $this;
        }
        $calls = $this->_actualCalls();
        $expected = MethodCall::newInstance($name, $arguments)->toString() . ' is called ' . $this->times . ' times';
        $this->_fail("Called method incorrect times", $expected, $calls);
    }
}
