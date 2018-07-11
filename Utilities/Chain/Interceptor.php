<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Chain;

interface Interceptor
{
    /**
     * @param mixed $param
     * @param Chain $chain
     * @return mixed
     */
    public function handle($param, Chain $chain);
}
