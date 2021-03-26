<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\ToString;

class NoClassNameToStringStyle extends ToStringStyle
{
    public function __construct()
    {
        $this->setUseClassName(false);
    }
}
