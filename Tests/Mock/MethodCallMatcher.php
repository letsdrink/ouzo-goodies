<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests\Mock;

use Ouzo\Utilities\Arrays;
use Ouzo\Utilities\Objects;

class MethodCallMatcher
{
    private string $name;
    private array $arguments;

    public function __construct(string $name, array $arguments)
    {
        $this->name = $name;
        $this->arguments = $arguments;
    }

    public function matches(MethodCall $methodCall): bool
    {
        if ($methodCall->name != $this->name) {
            return false;
        }

        if (Arrays::firstOrNull($this->arguments) instanceof AnyArgumentList) {
            return true;
        }

        if (count($methodCall->arguments) != count($this->arguments)) {
            return false;
        }

        foreach ($this->arguments as $i => $arg) {
            if (!$this->argMatches($arg, $methodCall->arguments[$i])) {
                return false;
            }
        }
        return true;
    }

    public function argMatches(mixed $expected, mixed $actual): bool
    {
        return ($expected instanceof ArgumentMatcher && $expected->matches($actual)) || Objects::equal($expected, $actual);
    }

    public function __invoke(MethodCall $methodCall): bool
    {
        return $this->matches($methodCall);
    }
}
