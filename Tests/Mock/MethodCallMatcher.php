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
    /** @var string */
    private $name;
    /** @var string */
    private $arguments;

    /**
     * @param string $name
     * @param array $arguments
     */
    public function __construct($name, $arguments)
    {
        $this->name = $name;
        $this->arguments = $arguments;
    }

    /**
     * @param MethodCall $methodCall
     * @return bool
     */
    public function matches(MethodCall $methodCall)
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

    /**
     * @param mixed $expected
     * @param mixed $actual
     * @return bool
     */
    public function argMatches($expected, $actual)
    {
        return ($expected instanceof ArgumentMatcher && $expected->matches($actual)) || Objects::equal($expected, $actual);
    }

    /**
     * @param MethodCall $methodCall
     * @return bool
     */
    public function __invoke(MethodCall $methodCall)
    {
        return $this->matches($methodCall);
    }
}
