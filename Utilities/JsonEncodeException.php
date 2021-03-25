<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

class JsonEncodeException extends \Exception
{
    public function __construct(string $lastErrorMessage = '', int $lastErrorCode = 0)
    {
        parent::__construct("JSON encode error: {$lastErrorMessage}", $lastErrorCode);
    }
}
