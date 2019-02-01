<?php

namespace Ouzo\Utilities;

class ScriptExecutionContext
{
    public static function isConsole()
    {
        return Strings::equal(self::getInterface(), 'cli');
    }

    public static function getInterface()
    {
        return php_sapi_name();
    }
}