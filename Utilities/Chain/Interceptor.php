<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Chain;

interface Interceptor
{
    public function handle(mixed $param, Chain $next): mixed;
}
