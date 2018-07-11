<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Chain;

class ChainHandler implements Chain
{
    /** @var Chain */
    private $next;
    /** @var Interceptor */
    private $interceptor;

    /**
     * @param Chain $next
     * @param Interceptor $interceptor
     */
    public function __construct(Chain $next, Interceptor $interceptor)
    {
        $this->next = $next;
        $this->interceptor = $interceptor;
    }

    /** @inheritdoc */
    public function proceed($param)
    {
        return $this->interceptor->handle($param, $this->next);
    }

    public function __invoke($param)
    {
        return $this->proceed($param);
    }
}
