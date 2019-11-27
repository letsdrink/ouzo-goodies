<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Loop;

class Loop
{
    /** @var int */
    private $iterations;
    /** @var int */
    private $delay;
    /** @var callable|null */
    private $functionForEach;
    /** @var callable|null */
    private $functionForEveryNth;
    /** @var int|null */
    private $n;

    /** @var int */
    private $currentIteration = 0;

    public function __construct(int $iterations, int $delay, ?callable $functionForEach, ?callable $functionForEveryNth, ?int $n)
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

            if (is_callable($this->functionForEveryNth) && $this->n > 0 && $this->currentIteration % $this->n === 0) {
                $function = $this->functionForEveryNth;
                $function($this->currentIteration);
            }

            sleep($this->delay);
            $this->currentIteration++;
        }
    }
}
