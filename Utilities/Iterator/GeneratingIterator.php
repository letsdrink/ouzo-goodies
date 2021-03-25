<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Iterator;

use Closure;
use Iterator;

class GeneratingIterator implements Iterator
{
    private int $index;
    private mixed $current;
    private bool $initialized;
    private Closure $function;

    public function __construct(callable $function)
    {
        $this->function = Closure::fromCallable($function);
    }

    public function current(): mixed
    {
        if (!$this->initialized) {
            $this->generate();
            $this->initialized = true;
        }
        return $this->current;
    }

    public function valid(): bool
    {
        return true;
    }

    public function key(): int
    {
        return $this->index;
    }

    public function next(): void
    {
        $this->index++;
        $this->generate();
    }

    public function rewind(): void
    {
        $this->index = 0;
        $this->initialized = false;
    }

    private function generate(): void
    {
        $function = $this->function;
        $this->current = $function($this->index);
    }
}
