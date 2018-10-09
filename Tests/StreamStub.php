<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests;

class StreamStub
{
    public $context;

    public static $position = 0;
    public static $body = '';
    public static $streamName;

    public function stream_open($path, $mode, $options, &$opened_path)
    {
        return true;
    }

    public function stream_read($bytes)
    {
        $chunk = substr(static::$body, static::$position, $bytes);
        static::$position += strlen($chunk);
        return $chunk;
    }

    public function stream_write($data)
    {
        static::$body .= $data;
        return strlen($data);
    }

    public function stream_eof()
    {
        return static::$position >= strlen(static::$body);
    }

    public function stream_tell()
    {
        return static::$position;
    }

    public function stream_stat()
    {
        return [];
    }

    public function stream_seek($offset, $whence)
    {
        static::$position = $offset;
        return true;
    }

    public function stream_close()
    {
        return null;
    }

    public static function register($streamName)
    {
        self::$streamName = $streamName;
        stream_wrapper_register($streamName, StreamStub::class);
    }

    public static function unregister()
    {
        stream_wrapper_unregister(self::$streamName);
        self::_reset();
    }

    private static function _reset()
    {
        static::$body = '';
        static::$position = 0;
    }
}
