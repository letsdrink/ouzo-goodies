<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\ToString;

use Ouzo\Utilities\Strings;

class SimpleToStringStyle extends ToStringStyle
{
    public function __construct()
    {
        $this->setUseClassName(false);
        $this->setUseFieldNames(false);
        $this->setContentStart(Strings::EMPTY_STRING);
        $this->setContentEnd(Strings::EMPTY_STRING);
    }
}
