<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\ToString;

class NoFieldNameToStringStyle extends ToStringStyle
{
    public function __construct()
    {
        $this->setUseFieldNames(false);
    }
}
