<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Supplier;

use Closure;

class MemoizingSupplier implements Supplier
{
    private bool $invoked = false;
    private mixed $cachedResult;

    public function __construct(private Closure $function)
    {
    }

    public function get(): mixed
    {
        if (!$this->invoked) {
            $function = $this->function;
            $this->cachedResult = $function();
            $this->invoked = true;
        }
        return $this->cachedResult;
    }
}
