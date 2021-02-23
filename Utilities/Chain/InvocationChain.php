<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Chain;

use Closure;

class InvocationChain implements Chain
{
    public function __construct(private Closure $invocation)
    {
    }

    public function proceed(mixed $param): mixed
    {
        $invocation = $this->invocation;
        return $invocation($param);
    }

    public function __invoke(mixed $param): mixed
    {
        return $this->proceed($param);
    }
}
