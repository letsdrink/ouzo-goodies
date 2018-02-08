<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests\Mock;

use PHPUnit\Framework\Assert;

class NotCalledVerifier extends Verifier
{
    /**
     * @param string $name
     * @param array $arguments
     * @return $this
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if (!$this->wasCalled($name, $arguments)) {
            Assert::assertTrue(!$this->wasCalled($name, $arguments));
            return $this;
        } else {
            $calls = $this->actualCalls();
            $expected = MethodCall::newInstance($name, $arguments)->toString() . ' is never called';
            Assert::assertEquals($expected, $calls, "Unwanted method was called");
        }
    }
}
