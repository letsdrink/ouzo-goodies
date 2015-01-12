<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests\Mock;

class NotCalledVerifier extends Verifier
{
    public function __call($name, $arguments)
    {
        if (!$this->_wasCalled($name, $arguments)) {
            return $this;
        }
        $calls = $this->_actualCalls();
        $expected = MethodCall::newInstance($name, $arguments)->toString() . ' is never called';
        $this->_fail("Unwanted method was called", $expected, $calls);
    }
}
