<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

use DateInterval;
use DateTime;
use DateTimeZone;

class Date
{
    const DEFAULT_TIME_FORMAT = 'Y-m-d H:i';
    const DEFAULT_TIMEZONE = 'UTC';

    public static function formatDate(?string $date, string $format = 'Y-m-d'): ?string
    {
        if (empty($date)) {
            return null;
        }
        $date = new DateTime($date);
        return $date->format($format);
    }

    public static function formatDateTime(?string $date, string $format = self::DEFAULT_TIME_FORMAT): ?string
    {
        return self::formatDate($date, $format);
    }

    /**
     * Adds interval to current time and returns a formatted date.
     *
     * @link http://php.net/manual/en/dateinterval.construct.php
     */
    public static function addInterval(string $interval, string $format = self::DEFAULT_TIME_FORMAT): string
    {
        $date = Clock::now()->toDateTime();
        $date->add(new DateInterval($interval));
        return $date->format($format);
    }

    /**
     * Modifies the current time and returns a formatted date.
     *
     * @link http://php.net/manual/en/datetime.formats.php
     */
    public static function modifyNow(string $interval, string $format = self::DEFAULT_TIME_FORMAT): string
    {
        return Clock::now()
            ->toDateTime()
            ->modify($interval)
            ->format($format);
    }

    /**
     * Modifies the given date string and returns a formatted date.
     *
     * @link http://php.net/manual/en/datetime.formats.php
     */
    public static function modify(string $dateAsString, string $interval, string $format = self::DEFAULT_TIME_FORMAT): string
    {
        $dateTime = new DateTime($dateAsString);
        return $dateTime->modify($interval)->format($format);
    }

    /**
     * Returns the beginning of a day for the given date.
     *
     * Example:
     * <code>
     * $date = '2013-09-09 13:03:43';
     * $begin = Date::beginningOfDay($date);
     * </code>
     * Result:
     * <code>
     * 2013-09-09 00:00:00
     * </code>
     */
    public static function beginningOfDay(string $date): string
    {
        return self::formatDate($date) . ' 00:00:00';
    }

    /**
     * Returns end of a day for the given date.
     *
     * Example:
     * <code>
     * $date = '2013-09-09 13:03:43';
     * $end = Date::endOfDay($date);
     * </code>
     * Result:
     * <code>
     * 2013-09-09 23:59:59.999
     * </code>
     */
    public static function endOfDay(string $date): string
    {
        return self::formatDate($date) . ' 23:59:59.999';
    }

    public static function formatTime(?string $time, string $format = 'H:i'): ?string
    {
        return self::formatDate($time, $format);
    }

    /** Returns formatted Unix timestamp. */
    public static function formatTimestamp(int $timestamp, string $format = self::DEFAULT_TIME_FORMAT, string $timezone = self::DEFAULT_TIMEZONE): string
    {
        $dateTime = new DateTime();
        $dateTime->setTimestamp($timestamp);
        $dateTime->setTimezone(new DateTimeZone($timezone));
        return $dateTime->format($format);
    }
}
