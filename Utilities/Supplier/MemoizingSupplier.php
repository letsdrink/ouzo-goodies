<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities\Supplier;

/**
 * Class MemoizingSupplier
 * @package Ouzo\Utilities\Supplier
 */
class MemoizingSupplier implements Supplier
{
    /** @var bool */
    private $invoked = false;
    /** @var mixed */
    private $cachedResult;
    /** @var callable */
    private $function;

    /**
     * @param callable $function
     */
    public function __construct($function)
    {
        $this->function = $function;
    }

    /**
     * @inheritdoc
     */
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
