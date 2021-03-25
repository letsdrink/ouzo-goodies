<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Tests;

use Throwable;

class CatchExceptionObject
{
    private object $object;

    public function __construct(object $object)
    {
        $this->object = $object;
    }

    public function __call(string $method, array $args): void
    {
        try {
            call_user_func_array([$this->object, $method], $args);
        } catch (Throwable $exception) {
            CatchException::$exception = $exception;
        }
    }
}
