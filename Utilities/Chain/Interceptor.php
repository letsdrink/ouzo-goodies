<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Chain;

interface Interceptor
{
    public function handle(mixed $param, Chain $next): mixed;
}
