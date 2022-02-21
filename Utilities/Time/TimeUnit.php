<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Time;

class TimeUnit
{
    public const DAYS = 'DAYS';
    public const HOURS = 'HOURS';
    public const MICROSECONDS = 'MICROSECONDS';
    public const MILLISECONDS = 'MILLISECONDS';
    public const MINUTES = 'MINUTES';
    public const NANOSECONDS = 'NANOSECONDS';
    public const SECONDS = 'SECONDS';

    public static function convert(int $nanos, string $timeUnit): int
    {
        $seconds = $nanos / (1000 * 1000 * 1000);
        return (int)match ($timeUnit) {
            self::NANOSECONDS => $nanos,
            self::MICROSECONDS => $nanos / 1000,
            self::MILLISECONDS => $nanos / (1000 * 1000),
            self::SECONDS => $seconds,
            self::MINUTES => floor($seconds / 60),
            self::HOURS => floor($seconds / 60 / 60),
            self::DAYS => floor($seconds / 60 / 60 / 24),
        };
    }
}
