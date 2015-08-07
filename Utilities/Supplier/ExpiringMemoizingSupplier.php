<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities\Supplier;

use Ouzo\Utilities\Clock;

/**
 * Class ExpiringMemoizingSupplier
 * @package Ouzo\Utilities\Supplier
 */
class ExpiringMemoizingSupplier implements Supplier
{
    /** @var mixed */
    private $cachedResult;
    /** @var int */
    private $lastCallTime;
    /** @var callable */
    private $function;
    /** @var int */
    private $expireTime;

    /**
     * @param callable $function
     * @param int $expireTime
     */
    public function __construct($function, $expireTime = 3600)
    {
        $this->function = $function;
        $this->expireTime = $expireTime;
    }

    /**
     * @inheritdoc
     */
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
