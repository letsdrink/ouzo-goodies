<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\ToString;

class MultiLineToStringStyle extends ToStringStyle
{
    public function __construct()
    {
        $this->setContentStart($this->getContentStart());
        $this->setContentEnd(PHP_EOL . $this->getContentEnd());
        $this->setFieldSeparator(PHP_EOL . "  ");
        $this->setFieldSeparatorAtStart(true);
    }
}
