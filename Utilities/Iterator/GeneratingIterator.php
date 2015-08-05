<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities\Iterator;

use Iterator;

class GeneratingIterator implements Iterator
{
    private $index;
    private $current;
    private $function;
    private $initialized;

    public function __construct($function)
    {
        $this->function = $function;
    }

    public function current()
    {
        if (!$this->initialized) {
            $this->generate();
            $this->initialized = true;
        }
        return $this->current;
    }

    public function valid()
    {
        return true;
    }

    public function key()
    {
        return $this->index;
    }

    public function next()
    {
        $this->index++;
        $this->generate();
    }

    public function rewind()
    {
        $this->index = 0;
        $this->initialized = false;
    }

    private function generate()
    {
        $function = $this->function;
        $this->current = $function($this->index);
    }
}
