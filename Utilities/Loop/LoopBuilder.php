<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Loop;

use Closure;

class LoopBuilder
{
    private int $delay = 1;
    private ?Closure $functionForEach = null;
    /** @var Closure[] */
    private array $functionForEveryNth = [];
    /** @var int[] */
    private array $n = [];

    public function __construct(private int $iterations)
    {
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
        $this->functionForEveryNth[] = $function;
        $this->n[] = $n;
        return $this;
    }

    public function run(): void
    {
        $loop = new Loop($this->iterations, $this->delay, $this->functionForEach, $this->functionForEveryNth, $this->n);
        $loop->run();
    }
}
