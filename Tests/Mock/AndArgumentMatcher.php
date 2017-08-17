<?php

namespace Ouzo\Tests\Mock;


use Ouzo\Utilities\Arrays;
use Ouzo\Utilities\Functions;

class AndArgumentMatcher implements ArgumentMatcher
{
    private $matchers;

    /**
     * AndArgumentMatcher constructor.
     * @param ArgumentMatcher[] $matchers
     */
    public function __construct(array $matchers)
    {
        $this->matchers = $matchers;
    }

    public function matches($argument)
    {
        return Arrays::all($this->matchers, Functions::extract()->matches($argument));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(' and ', $this->matchers);
    }
}