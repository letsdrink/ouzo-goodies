<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Loop;

use Closure;

class Loop
{
    private int $iterations;
    private int $delay;
    private ?Closure $functionForEach;
    private ?Closure $functionForEveryNth;
    private ?int $n;

    private int $currentIteration = 0;

    public function __construct(int $iterations, int $delay, ?Closure $functionForEach, ?Closure $functionForEveryNth, ?int $n)
    {
        $this->iterations = $iterations;
        $this->delay = $delay;
        $this->functionForEach = $functionForEach;
        $this->functionForEveryNth = $functionForEveryNth;
        $this->n = $n;
    }

    public static function of(int $iterations): LoopBuilder
    {
        return new LoopBuilder($iterations);
    }

    public static function forever(): LoopBuilder
    {
        return new LoopBuilder(0);
    }

    public function run(): void
    {
        while ($this->iterations === 0 || $this->currentIteration < $this->iterations) {
            if (is_callable($this->functionForEach)) {
                $function = $this->functionForEach;
                $function($this->currentIteration);
            }

            if (is_callable($this->functionForEveryNth) && $this->n > 0 && ($this->currentIteration % $this->n === 0)) {
                $function = $this->functionForEveryNth;
                $function($this->currentIteration);
            }

            sleep($this->delay);
            $this->currentIteration++;
        }
    }
}
