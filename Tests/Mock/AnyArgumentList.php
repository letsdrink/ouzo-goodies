<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests\Mock;

class AnyArgumentList
{
    /**
     * @return string
     */
    public function __toString()
    {
        return "any arguments";
    }
}
