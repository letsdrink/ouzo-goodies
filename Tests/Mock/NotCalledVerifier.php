<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests\Mock;

use PHPUnit\Framework\Assert;

class NotCalledVerifier extends Verifier
{
    public function __call(string $name, array $arguments): NotCalledVerifier
    {
        if (!$this->wasCalled($name, $arguments)) {
            Assert::assertTrue(!$this->wasCalled($name, $arguments));
        } else {
            $calls = $this->actualCalls();
            $expected = MethodCall::newInstance($name, $arguments)->toString() . ' is never called';
            Assert::assertEquals($expected, $calls, "Unwanted method was called");
        }
        return $this;
    }
}
