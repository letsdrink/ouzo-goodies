<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests\Mock;


use Ouzo\Utilities\Arrays;
use Ouzo\Utilities\Functions;

class AndArgumentMatcher implements ArgumentMatcher
{
    private array $matchers;

    public function __construct(array $matchers)
    {
        $this->matchers = $matchers;
    }

    public function matches(mixed $argument): bool
    {
        return Arrays::all($this->matchers, Functions::extract()->matches($argument));
    }

    public function __toString(): string
    {
        return implode(' and ', $this->matchers);
    }
}