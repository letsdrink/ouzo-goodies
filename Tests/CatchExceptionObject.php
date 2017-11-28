<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests;

use Exception;
use Throwable;

class CatchExceptionObject
{
    /** @var object */
    private $object;

    /**
     * @param object $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }

    /**
     * @param string $method
     * @param array $args
     */
    public function __call($method, $args)
    {
        try {
            call_user_func_array([$this->object, $method], $args);
        } catch (Exception $exception) {
            CatchException::$exception = $exception;
        } catch (Throwable $exception) {
            CatchException::$exception = $exception;
        }
    }
}
