<?php
namespace Ouzo\Tests\Mock;

use Ouzo\Utilities\Arrays;

class SimpleMock
{
    public $_stubbed_calls = array();
    public $_called_methods = array();

    public function __call($name, $arguments)
    {
        $methodCall = new MethodCall($name, $arguments);
        $this->_called_methods[] = $methodCall;

        $matching = $this->getMatchingStubbedCalls($methodCall);

        if (empty($matching)) {
            return null;
        }

        $firstMatching = Arrays::first($matching);
        $this->removeMatchedCall($matching);

        return $firstMatching->evaluate($methodCall);
    }

    private function getMatchingStubbedCalls($methodCall)
    {
        $matching = Arrays::filter($this->_stubbed_calls, function ($stubbed_call) use ($methodCall) {
            return $stubbed_call->matches($methodCall);
        });
        return $matching;
    }

    private function removeMatchedCall($matching)
    {
        if (count($matching) > 1) {
            array_shift($this->_stubbed_calls);
        }
    }
}
