<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities\Supplier;

class MemoizingSupplier
{
    private $invoked = false;
    private $cachedResult;
    private $function;

    public function __construct($function)
    {
        $this->function = $function;
    }

    public function get()
    {
        if (!$this->invoked) {
            $function = $this->function;
            $this->cachedResult = $function();
            $this->invoked = true;
        }
        return $this->cachedResult;
    }
}