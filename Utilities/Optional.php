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
        $value = $this->object;
        if ($value === null) {
            throw new Exception('Optional value is null');
        }
        return $value;
    }

    private function _or($alternativeValue)
    {
        $value = $this->object;
        if ($value === null) {
            return $alternativeValue;
        }
        return $value;
    }

    private function _orNull()
    {
        return $this->_or(null);
    }

    public function __call($name, $arguments)
    {
        if (!in_array($name, array('isPresent', 'get', 'or', 'orNull'))) {
            if (!method_exists($this->object, $name)) {
                return Optional::absent();
            }
            return Optional::fromNullable(call_user_func_array(array($this->object, $name), $arguments));
        }
        return call_user_func_array(array($this, '_' . $name), $arguments);
    }

    public function __get($field)
    {
        if (!property_exists($this->object, $field)) {
            return Optional::absent();
        }
        return Optional::fromNullable($this->object->$field);
    }
}