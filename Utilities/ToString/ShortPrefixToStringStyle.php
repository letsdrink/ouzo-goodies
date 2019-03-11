<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\ToString;

class ShortPrefixToStringStyle extends ToStringStyle
{
    public function __construct()
    {
        $this->setUseShortClassName(true);
    }
}
