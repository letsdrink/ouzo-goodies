<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
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
