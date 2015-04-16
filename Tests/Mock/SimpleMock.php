<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
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
        $this->removeMatchedCallIfMultipleResults($matching);

        return $firstMatching->evaluate($methodCall);
    }

    private function getMatchingStubbedCalls($methodCall)
    {
        $matching = Arrays::filter($this->_stubbed_calls, function ($stubbed_call) use ($methodCall) {
            return $stubbed_call->matches($methodCall);
        });
        return $matching;
    }

    private function removeMatchedCallIfMultipleResults($matching)
    {
        if (count($matching) > 1) {
            $this->removeStubbedCall(Arrays::first($matching));
        }
    }

    private function removeStubbedCall($call)
    {
        if (($key = array_search($call, $this->_stubbed_calls)) !== false) {
            unset($this->_stubbed_calls[$key]);
        }
    }
}
