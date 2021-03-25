<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

use ArrayAccess;
use BadMethodCallException;

/**
 * Sample usage:
 *
 * <code>
 *  $cities = Arrays::map($users, Functions::extract()->getAddress('home')->city);
 * </code>
 */
class Extractor implements ArrayAccess
{
    private array $operations = [];

    public function __get($field): static
    {
        $this->operations[] = fn($input) => Objects::getValue($input, $field);
        return $this;
    }

    public function __call($name, $arguments): static
    {
        $this->operations[] = fn($input) => call_user_func_array([$input, $name], $arguments);
        return $this;
    }

    public function __invoke($input)
    {
        foreach ($this->operations as $operation) {
            $input = $operation($input);
            if ($input === null) {
                return null;
            }
        }
        return $input;
    }

    public function offsetGet($offset): static
    {
        $this->operations[] = fn($input) => isset($input[$offset]) ? $input[$offset] : null;
        return $this;
    }

    public function offsetExists($offset): bool
    {
        throw new BadMethodCallException();
    }

    public function offsetSet($offset, $value): void
    {
        throw new BadMethodCallException();
    }

    public function offsetUnset($offset): void
    {
        throw new BadMethodCallException();
    }
}
