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

    private function __construct(private string $timeUnit)
    {
    }

    public static function of(TimeUnit|string $timeUnit): self
    {
        return $timeUnit instanceof TimeUnit ? $timeUnit : new TimeUnit($timeUnit);
    }

    public static function days(): self
    {
        return new TimeUnit(TimeUnit::DAYS);
    }

    public static function hours(): self
    {
        return new TimeUnit(TimeUnit::HOURS);
    }

    public static function minutes(): self
    {
        return new TimeUnit(TimeUnit::MINUTES);
    }

    public static function seconds(): self
    {
        return new TimeUnit(TimeUnit::SECONDS);
    }

    public static function micros(): self
    {
        return new TimeUnit(TimeUnit::MICROSECONDS);
    }

    public static function millis(): self
    {
        return new TimeUnit(TimeUnit::MILLISECONDS);
    }

    public static function nanos(): self
    {
        return new TimeUnit(TimeUnit::NANOSECONDS);
    }

    public function convert(int $sourceDuration, string $sourceTimeUnit): int
    {
        $nanos = $this->convertToNanos($sourceDuration, $sourceTimeUnit);
        return (int)match ($this->timeUnit) {
            self::NANOSECONDS => $nanos,
            self::MICROSECONDS => $nanos / 1000,
            self::MILLISECONDS => $nanos / 1000 / 1000,
            self::SECONDS => $nanos / 1000 / 1000 / 1000,
            self::MINUTES => floor($nanos / 1000 / 1000 / 1000 / 60),
            self::HOURS => floor($nanos / 1000 / 1000 / 1000 / 60 / 60),
            self::DAYS => floor($nanos / 1000 / 1000 / 1000 / 60 / 60 / 24),
        };
    }

    private function convertToNanos(int $sourceDuration, string $sourceTimeUnit): int
    {
        return (int)match ($sourceTimeUnit) {
            self::NANOSECONDS => $sourceDuration,
            self::MICROSECONDS => $sourceDuration * 1000,
            self::MILLISECONDS => $sourceDuration * 1000 * 1000,
            self::SECONDS => $sourceDuration * 1000 * 1000 * 1000,
            self::MINUTES => $sourceDuration * 1000 * 1000 * 1000 * 60,
            self::HOURS => $sourceDuration * 1000 * 1000 * 1000 * 60 * 60,
            self::DAYS => $sourceDuration * 1000 * 1000 * 1000 * 60 * 60 * 24,
        };
    }

    public function __toString(): string
    {
        return $this->timeUnit;
    }
}
