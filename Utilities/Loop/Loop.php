<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Loop;

use Closure;

class Loop
{
    private int $currentIteration = 0;

    /**
     * @param Closure[] $functionForEveryNth
     * @param int[] $n
     */
    public function __construct(
        private int $iterations,
        private int $delay,
        private ?Closure $functionForEach,
        private array $functionForEveryNth,
        private array $n,
    )
    {
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

            for ($i = 0; $i < sizeof($this->functionForEveryNth); $i++) {
                $function = $this->functionForEveryNth[$i];
                $n = $this->n[$i];
                if (is_callable($function) && $n > 0 && ($this->currentIteration % $n === 0)) {
                    $function($this->currentIteration);
                }
            }

            sleep($this->delay);
            $this->currentIteration++;
        }
    }
}
