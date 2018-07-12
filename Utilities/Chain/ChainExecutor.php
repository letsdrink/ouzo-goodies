<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Chain;

use Closure;

class ChainExecutor
{
    /** @var Interceptor[] */
    private $interceptors = [];

    /**
     * @param Interceptor $interceptor
     * @return $this
     */
    public function add(Interceptor $interceptor)
    {
        $this->interceptors[] = $interceptor;
        return $this;
    }

    /**
     * @param Interceptor[] $interceptors
     * @return $this
     */
    public function addAll(array $interceptors)
    {
        foreach ($interceptors as $interceptor) {
            $this->add($interceptor);
        }
        return $this;
    }

    /**
     * @param mixed $param
     * @param Closure $function
     * @return mixed
     */
    public function execute($param, Closure $function)
    {
        $chain = new InvocationChain($function);

        $interceptors = array_reverse($this->interceptors);
        foreach ($interceptors as $interceptor) {
            $chain = new ChainHandler($chain, $interceptor);
        }

        return $chain->proceed($param);
    }
}
