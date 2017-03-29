<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
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
 * @method mixed map($closure)
 * @method mixed flatten
 */
class Optional
{
    private $object;

    private function __construct($object)
    {
        $this->object = $object;
    }

    public static function of($object)
    {
        if ($object === null) {
            throw new InvalidArgumentException('Object cannot be null. Use fromNullable if you want to pass null.');
        }
        return new self($object);
    }

    private static function absent()
    {
        return new self(null);
    }

    public static function fromNullable($object)
    {
        return new self($object);
    }

    private function _isPresent()
    {
        return $this->object !== null;
    }

    private function _get()
    {
        if ($this->isPresent()) {
            return $this->object;
        }
        throw new Exception('Optional value is null');
    }

    private function _or($alternativeValue)
    {
        if ($this->isPresent()) {
            return $this->object;
        }
        return $alternativeValue;
    }

    private function _orNull()
    {
        return $this->_or(null);
    }

    private function _map($closure)
    {
        if ($this->isPresent()) {
            return Optional::fromNullable(Functions::call($closure, $this->object));
        }
        return Optional::absent();
    }

    private function _flatten()
    {
        $object = $this->object;
        while ($object instanceof Optional) {
            $object = $object->orNull();
        }
        return Optional::fromNullable($object);
    }

    public function __call($name, $arguments)
    {
        if (!in_array($name, ['isPresent', 'get', 'or', 'orNull', 'map', 'flatten'])) {
            if (!method_exists($this->object, $name)) {
                return Optional::absent();
            }
            return Optional::fromNullable(call_user_func_array([$this->object, $name], $arguments));
        }
        return call_user_func_array([$this, '_' . $name], $arguments);
    }

    public function __get($field)
    {
        if (!$this->isPresent() || !property_exists($this->object, $field)) {
            return Optional::absent();
        }
        return Optional::fromNullable($this->object->$field);
    }
}
