<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Loop;

class LoopBuilder
{
    /** @var int */
    private $iterations;
    /** @var int */
    private $delay = 1;
    /** @var callable */
    private $functionForEach;
    /** @var callable */
    private $functionForEveryNth;
    /** @var int */
    private $n;

    public function __construct(int $iterations)
    {
        $this->iterations = $iterations;
    }

    public function withFixedDelay(int $seconds): LoopBuilder
    {
        $this->delay = $seconds;
        return $this;
    }

    public function forEach(callable $function): LoopBuilder
    {
        $this->functionForEach = $function;
        return $this;
    }

    public function forEveryNth(int $n, callable $function): LoopBuilder
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
