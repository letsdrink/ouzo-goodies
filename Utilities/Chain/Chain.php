<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Chain;

interface Chain
{
    /**
     * @param mixed $param
     * @return Chain|void
     */
    public function proceed($param);
}
