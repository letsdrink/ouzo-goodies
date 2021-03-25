<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

use Exception;
use InvalidArgumentException;

/**
 * @method bool isPresent
 * @method mixed get
 * @method mixed or
 * @method mixed orNull
 * @method mixed map(callable $closure)
 * @method mixed flatten
 */
class Optional
{
    private function __construct(private mixed $object)
    {
    }

    public static function of(mixed $object): Optional
    {
        if (is_null($object)) {
            throw new InvalidArgumentException('Object cannot be null. Use fromNullable if you want to pass null.');
        }
        return new self($object);
    }

    private static function absent(): Optional
    {
        return new self(null);
    }

    public static function fromNullable(mixed $object): Optional
    {
        return new self($object);
    }

    private function _isPresent(): bool
    {
        return $this->object !== null;
    }

    private function _get(): mixed
    {
        if ($this->isPresent()) {
            return $this->object;
        }
        throw new Exception('Optional value is null');
    }

    private function _or(mixed $alternativeValue): mixed
    {
        if ($this->isPresent()) {
            return $this->object;
        }
        return $alternativeValue;
    }

    private function _orNull(): mixed
    {
        return $this->_or(null);
    }

    private function _map(callable $closure): Optional
    {
        if ($this->isPresent()) {
            return Optional::fromNullable(Functions::call($closure, $this->object));
        }
        return Optional::absent();
    }

    private function _flatten(): Optional
    {
        $object = $this->object;
        while ($object instanceof Optional) {
            $object = $object->orNull();
        }
        return Optional::fromNullable($object);
    }

    public function __call(string $name, mixed $arguments): mixed
    {
        if (!in_array($name, ['isPresent', 'get', 'or', 'orNull', 'map', 'flatten'])) {
            if (!method_exists($this->object, $name)) {
                return Optional::absent();
            }
            return Optional::fromNullable(call_user_func_array([$this->object, $name], $arguments));
        }
        return call_user_func_array([$this, '_' . $name], $arguments);
    }

    public function __get(mixed $field): Optional
    {
        if (!$this->isPresent() || !property_exists($this->object, $field)) {
            return Optional::absent();
        }
        return Optional::fromNullable($this->object->$field);
    }
}
