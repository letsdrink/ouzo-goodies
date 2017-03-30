<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

class JsonDecodeException extends \Exception
{
    public function __construct($lastErrorMessage = "", $lastErrorCode = 0)
    {
        parent::__construct('JSON decode error: ' . $lastErrorMessage, $lastErrorCode);
    }
}
