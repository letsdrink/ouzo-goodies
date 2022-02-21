<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

use ArrayAccess;
use BadMethodCallException;
use InvalidArgumentException;

class NonCallableExtractor implements ArrayAccess
{
    private Extractor $extractor;

    public function __construct()
    {
        $this->extractor = new Extractor();
    }

    public function __get(string $field): Extractor
    {
        $this->extractor->__get($field);
        return $this->extractor;
    }

    public function __call(string $name, mixed $arguments): Extractor
    {
        $this->extractor->__call($name, $arguments);
        return $this->extractor;
    }

    public function offsetGet(mixed $offset): Extractor
    {
        $this->extractor->offsetGet($offset);
        return $this->extractor;
    }

    public function offsetExists(mixed $offset): bool
    {
        throw new BadMethodCallException();
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new BadMethodCallException();
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new BadMethodCallException();
    }

    public function __invoke(mixed $input): void
    {
        throw new InvalidArgumentException('Empty Extractor cannot be invoked!');
    }
}
