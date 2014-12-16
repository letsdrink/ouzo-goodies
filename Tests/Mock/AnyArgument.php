<?php
namespace Ouzo\Tests\Mock;

class AnyArgument implements ArgumentMatcher
{
    public function __toString()
    {
        return "any";
    }

    public function matches($argument)
    {
        return true;
    }
}
