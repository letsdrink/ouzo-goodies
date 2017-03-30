<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests\Mock;

class AnyArgument implements ArgumentMatcher
{
    /**
     * @return string
     */
    public function __toString()
    {
        return "any";
    }

    /**
     * @inheritdoc
     */
    public function matches($argument)
    {
        return true;
    }
}
