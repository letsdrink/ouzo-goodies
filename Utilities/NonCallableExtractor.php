<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

use ArrayAccess;
use BadMethodCallException;
use InvalidArgumentException;

class NonCallableExtractor implements ArrayAccess
{
    public function __construct()
    {
        $this->extractor = new Extractor();
    }

    public function __get($field)
    {
        $this->extractor->__get($field);
        return $this->extractor;
    }

    public function __call($name, $arguments)
    {
        $this->extractor->__call($name, $arguments);
        return $this->extractor;
    }

    public function offsetGet($offset)
    {
        $this->extractor->offsetGet($offset);
        return $this->extractor;
    }

    public function offsetExists($offset)
    {
        throw new BadMethodCallException();
    }

    public function offsetSet($offset, $value)
    {
        throw new BadMethodCallException();
    }

    public function offsetUnset($offset)
    {
        throw new BadMethodCallException();
    }

    public function __invoke($input)
    {
        throw new InvalidArgumentException("Empty Extractor cannot be invoked!");
    }
}
