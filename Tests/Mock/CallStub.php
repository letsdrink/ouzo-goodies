<?php
namespace Ouzo\Tests\Mock;

class CallStub
{
    public $methodCall;
    public $callback;

    public function __construct($methodCall, $callback)
    {
        $this->methodCall = $methodCall;
        $this->callback = $callback;
    }

    public function evaluate($methodCall)
    {
        return call_user_func($this->callback, $methodCall);
    }

    public function matches(MethodCall $methodCall)
    {
        $matcher = new MethodCallMatcher($this->methodCall->name, $this->methodCall->arguments);
        return $matcher->matches($methodCall);
    }
}
