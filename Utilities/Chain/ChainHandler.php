<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Chain;

class ChainHandler implements Chain
{
    public function __construct(private Chain $next, private Interceptor $interceptor)
    {
    }

    public function proceed(mixed $param): mixed
    {
        return $this->interceptor->handle($param, $this->next);
    }

    public function __invoke(mixed $param): mixed
    {
        return $this->proceed($param);
    }
}
