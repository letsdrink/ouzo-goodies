<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests\Mock;

interface ArgumentMatcher
{
    /**
     * @param mixed $argument
     * @return mixed
     */
    public function matches($argument);
}
