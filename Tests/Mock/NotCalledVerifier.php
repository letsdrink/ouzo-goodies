<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests\Mock;

class NotCalledVerifier extends Verifier
{
    /**
     * @param string $name
     * @param array $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        if (!$this->wasCalled($name, $arguments)) {
            return $this;
        }
        $calls = $this->actualCalls();
        $expected = MethodCall::newInstance($name, $arguments)->toString() . ' is never called';
        $this->fail("Unwanted method was called", $expected, $calls);
    }
}
