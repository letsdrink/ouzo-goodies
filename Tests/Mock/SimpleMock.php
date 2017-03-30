<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests\Mock;

use Ouzo\Utilities\Arrays;

class SimpleMock
{
    /** @var CallStub[] */
    public $stubbedCalls = [];
    /** @var MethodCall[] */
    public $calledMethods = [];

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $methodCall = new MethodCall($name, $arguments);
        $this->calledMethods[] = $methodCall;

        $matching = $this->getMatchingStubbedCalls($methodCall);

        if (empty($matching)) {
            return null;
        }

        $firstMatching = Arrays::first($matching);
        $this->removeMatchedCallIfMultipleResults($matching);

        return $firstMatching->evaluate($methodCall);
    }

    /**
     * @param MethodCall $methodCall
     * @return CallStub[]
     */
    private function getMatchingStubbedCalls(MethodCall $methodCall)
    {
        $matching = Arrays::filter($this->stubbedCalls, function (CallStub $stubbed_call) use ($methodCall) {
            return $stubbed_call->matches($methodCall);
        });
        return $matching;
    }

    /**
     * @param CallStub[] $matching
     * @return void
     */
    private function removeMatchedCallIfMultipleResults(array $matching)
    {
        if (count($matching) > 1) {
            $this->removeStubbedCall(Arrays::first($matching));
        }
    }

    /**
     * @param CallStub $call
     * @return void
     */
    private function removeStubbedCall(CallStub $call)
    {
        if (($key = array_search($call, $this->stubbedCalls)) !== false) {
            unset($this->stubbedCalls[$key]);
        }
    }
}
