<?php
namespace Ouzo\Utilities;


class JsonDecodeException extends \Exception
{
    public function __construct($lastErrorMessage = "", $lastErrorCode = 0)
    {
        parent::__construct('JSON decode error: ' . $lastErrorMessage, $lastErrorCode);
    }
}
