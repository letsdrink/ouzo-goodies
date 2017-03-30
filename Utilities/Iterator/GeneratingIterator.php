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
    /** @var int */
    private $index;
    /** @var mixed */
    private $current;
    /** @var Closure */
    private $function;
    /** @var bool */
    private $initialized;

    /**
     * @param Closure $function
     */
    public function __construct($function)
    {
        $this->function = $function;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        if (!$this->initialized) {
            $this->generate();
            $this->initialized = true;
        }
        return $this->current;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return true;
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * @return void
     */
    public function next()
    {
        $this->index++;
        $this->generate();
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->index = 0;
        $this->initialized = false;
    }

    /**
     * @return void
     */
    private function generate()
    {
        $function = $this->function;
        $this->current = $function($this->index);
    }
}
