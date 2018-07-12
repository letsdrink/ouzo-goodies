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
     * @param Chain $next
     * @return mixed|void
     */
    public function handle($param, Chain $next);
}
