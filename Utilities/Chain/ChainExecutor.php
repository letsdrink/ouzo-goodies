<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Chain;

use Closure;

class ChainExecutor
{
    /** @var Interceptor[] */
    private array $interceptors = [];

    public function add(Interceptor $interceptor): static
    {
        $this->interceptors[] = $interceptor;
        return $this;
    }

    /**
     * @param Interceptor[] $interceptors
     */
    public function addAll(array $interceptors): static
    {
        foreach ($interceptors as $interceptor) {
            $this->add($interceptor);
        }
        return $this;
    }

    public function execute(mixed $param, Closure $function): mixed
    {
        $chain = new InvocationChain($function);

        $interceptors = array_reverse($this->interceptors);
        foreach ($interceptors as $interceptor) {
            $chain = new ChainHandler($chain, $interceptor);
        }

        return $chain->proceed($param);
    }
}
