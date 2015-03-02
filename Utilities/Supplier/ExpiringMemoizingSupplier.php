<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities\Supplier;

use Ouzo\Utilities\Clock;

class ExpiringMemoizingSupplier
{
    private $cachedResult;
    private $lastCallTime;
    private $function;
    private $expireTime;

    public function __construct($function, $expireTime = 3600)
    {
        $this->function = $function;
        $this->expireTime = $expireTime;
    }

    public function get()
    {
        $function = $this->function;
        $now = Clock::now()->getTimestamp();
        if ($this->cachedResult === null || $now - $this->lastCallTime > $this->expireTime) {
            $this->cachedResult = $function();
            $this->lastCallTime = $now;
        }
        return $this->cachedResult;
    }
}