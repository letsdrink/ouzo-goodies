<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Loop;

use Closure;

class LoopBuilder
{
    private int $iterations;

    private int $delay = 1;
    private ?Closure $functionForEach = null;
    private ?Closure $functionForEveryNth = null;
    private ?int $n = null;

    public function __construct(int $iterations)
    {
        $this->iterations = $iterations;
    }

    public function withFixedDelay(int $seconds): LoopBuilder
    {
        $this->delay = $seconds;
        return $this;
    }

    public function forEach(Closure $function): LoopBuilder
    {
        $this->functionForEach = $function;
        return $this;
    }

    public function forEveryNth(int $n, Closure $function): LoopBuilder
    {
        $this->functionForEveryNth = $function;
        $this->n = $n;
        return $this;
    }

    public function run(): void
    {
        $loop = new Loop($this->iterations, $this->delay, $this->functionForEach, $this->functionForEveryNth, $this->n);
        $loop->run();
    }
}
