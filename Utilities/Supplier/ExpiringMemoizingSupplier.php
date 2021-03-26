<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Supplier;

use Closure;
use Ouzo\Utilities\Clock;

class ExpiringMemoizingSupplier implements Supplier
{
    private mixed $cachedResult = null;
    private int $lastCallTime;
    private Closure $function;

    public function __construct(callable $function, private int $expireTime = 3600)
    {
        $this->function = Closure::fromCallable($function);
    }

    public function get(): mixed
    {
        $function = $this->function;
        $now = Clock::now()->getTimestamp();
        if (is_null($this->cachedResult) || $now - $this->lastCallTime > $this->expireTime) {
            $this->cachedResult = $function();
            $this->lastCallTime = $now;
        }
        return $this->cachedResult;
    }
}
