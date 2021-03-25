<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests\Mock;

use Closure;

class CallStub
{
    public MethodCall $methodCall;
    public Closure $callback;

    public function __construct(MethodCall $methodCall, Closure $callback)
    {
        $this->methodCall = $methodCall;
        $this->callback = $callback;
    }

    public function evaluate(MethodCall $methodCall): mixed
    {
        return call_user_func($this->callback, $methodCall);
    }

    public function matches(MethodCall $methodCall): bool
    {
        $matcher = new MethodCallMatcher($this->methodCall->name, $this->methodCall->arguments);
        return $matcher->matches($methodCall);
    }
}
