<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests\Mock;

use Ouzo\Utilities\Arrays;

class SimpleMock implements MockInterface
{
    public array $stubbedCalls = [];
    public array $calledMethods = [];

    public function __call(string $name, array $arguments): mixed
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

    private function getMatchingStubbedCalls(MethodCall $methodCall): array
    {
        return Arrays::filter($this->stubbedCalls, function (CallStub $stubbed_call) use ($methodCall) {
            return $stubbed_call->matches($methodCall);
        });
    }

    /** @param CallStub[] $matching */
    private function removeMatchedCallIfMultipleResults(array $matching): void
    {
        if (count($matching) > 1) {
            $this->removeStubbedCall(Arrays::first($matching));
        }
    }

    private function removeStubbedCall(CallStub $call): void
    {
        if (($key = array_search($call, $this->stubbedCalls)) !== false) {
            unset($this->stubbedCalls[$key]);
        }
    }
}
