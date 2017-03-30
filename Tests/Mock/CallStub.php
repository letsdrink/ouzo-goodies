<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests\Mock;

use Closure;

class CallStub
{
    /** @var MethodCall */
    public $methodCall;
    /** @var Closure */
    public $callback;

    /**
     * @param MethodCall $methodCall
     * @param Closure $callback
     */
    public function __construct(MethodCall $methodCall, $callback)
    {
        $this->methodCall = $methodCall;
        $this->callback = $callback;
    }

    /**
     * @param string $methodCall
     * @return mixed
     */
    public function evaluate($methodCall)
    {
        return call_user_func($this->callback, $methodCall);
    }

    /**
     * @param MethodCall $methodCall
     * @return bool
     */
    public function matches(MethodCall $methodCall)
    {
        $matcher = new MethodCallMatcher($this->methodCall->name, $this->methodCall->arguments);
        return $matcher->matches($methodCall);
    }
}
