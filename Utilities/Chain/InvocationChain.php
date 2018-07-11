<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Chain;

use Closure;

class InvocationChain implements Chain
{
    /** @var Closure */
    private $invocation;

    /** @param Closure $invocation */
    public function __construct(Closure $invocation)
    {
        $this->invocation = $invocation;
    }

    /** @inheritdoc */
    public function proceed($param)
    {
        $invocation = $this->invocation;
        return $invocation($param);
    }

    public function __invoke($param)
    {
        return $this->proceed($param);
    }
}
