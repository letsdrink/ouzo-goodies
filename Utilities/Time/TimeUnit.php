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

    public function toDays(int $duration): int
    {
        return TimeUnit::of(TimeUnit::DAYS)->convert($duration, $this->timeUnit);
    }

    public function toHours(int $duration): int
    {
        return TimeUnit::of(TimeUnit::HOURS)->convert($duration, $this->timeUnit);
    }

    public function toMinutes(int $duration): int
    {
        return TimeUnit::of(TimeUnit::MINUTES)->convert($duration, $this->timeUnit);
    }

    public function toSeconds(int $duration): int
    {
        return TimeUnit::of(TimeUnit::SECONDS)->convert($duration, $this->timeUnit);
    }

    public function toMicros(int $duration): int
    {
        return TimeUnit::of(TimeUnit::MICROSECONDS)->convert($duration, $this->timeUnit);
    }

    public function toMillis(int $duration): int
    {
        return TimeUnit::of(TimeUnit::MILLISECONDS)->convert($duration, $this->timeUnit);
    }

    public function toNanos(int $duration): int
    {
        return TimeUnit::of(TimeUnit::NANOSECONDS)->convert($duration, $this->timeUnit);
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
