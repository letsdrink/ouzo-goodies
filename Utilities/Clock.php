<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

use DateTime;
use DateTimeZone;

class Clock
{
    public static bool $freeze = false;
    public static Clock|DateTime $freezeDate;

    public DateTime $dateTime;

    private DateTimeZone $dateTimeZone;

    public function __construct(DateTime $dateTime)
    {
        $this->dateTime = clone $dateTime;
        $this->dateTimeZone = $dateTime->getTimezone();
    }

    /** Freezes time to a specific point or current time if no time is given. */
    public static function freeze(string $date = null)
    {
        self::$freeze = false;
        self::$freezeDate = $date ? new DateTime($date) : self::now();
        self::$freeze = true;
    }

    /**
     * Returns current time as a string.
     *
     * Example:
     * <code>
     * Clock::freeze('2011-01-02 12:34');
     * $result = Clock::nowAsString('Y-m-d');
     * </code>
     * Result:
     * <code>
     * 2011-01-02
     * </code>
     */
    public static function nowAsString(string $format = null): string
    {
        return self::now()->format($format);
    }

    /** Obtains a Clock set to the current time. */
    public static function now(): Clock
    {
        $date = new DateTime();
        if (self::$freeze) {
            $date->setTimestamp(self::$freezeDate->getTimestamp());
            $date->setTimezone(self::$freezeDate->getTimezone());
        }
        return new Clock($date);
    }

    /** Obtains a Clock set to to a specific point. */
    public static function at(string $date): Clock
    {
        $dateTime = new DateTime($date);
        return new Clock($dateTime);
    }

    /** Obtains a Clock set to to a specific point using Unix timestamp. */
    public static function fromTimestamp(int $timestamp): Clock
    {
        $dateTime = new DateTime();
        $dateTime->setTimestamp($timestamp);
        return new Clock($dateTime);
    }

    public function getTimestamp(): int
    {
        return $this->dateTime->getTimestamp();
    }

    public function format(string $format = null): string
    {
        $format = $format ?: 'Y-m-d H:i:s';
        return $this->dateTime->format($format);
    }

    /** Converts this object to a DateTime */
    public function toDateTime(): DateTime
    {
        return $this->dateTime;
    }

    private function modify(string $interval): Clock
    {
        $dateTime = clone $this->dateTime;
        return new Clock($dateTime->modify($interval));
    }

    private function modifyWithDstChangeSupport(string $interval): Clock
    {
        $dateTime = clone $this->dateTime;
        $dateTimeZone = new DateTimeZone('GMT');
        return new Clock(
            $dateTime
                ->setTimezone($dateTimeZone)
                ->modify($interval)
                ->setTimezone($this->dateTimeZone)
        );
    }

    private function modifyMonths(string $interval): Clock
    {
        $dateTime = clone $this->dateTime;
        $currentDay = $dateTime->format('j');
        $dateTime->modify($interval);
        $endDay = $dateTime->format('j');
        if ($currentDay != $endDay) {
            $dateTime->modify('last day of last month');
        }
        return new Clock($dateTime);
    }

    public function minusDays(int $days): Clock
    {
        return $this->modify("-$days days");
    }

    public function minusHours(int $hours): Clock
    {
        return $this->modifyWithDstChangeSupport("-{$hours} hours");
    }

    public function minusMinutes(int $minutes): Clock
    {
        return $this->modifyWithDstChangeSupport("-{$minutes} minutes");
    }

    public function minusMonths(int $months): Clock
    {
        return $this->modifyMonths("-{$months} months");
    }

    public function minusSeconds(int $seconds): Clock
    {
        return $this->modifyWithDstChangeSupport("-{$seconds} seconds");
    }

    public function minusYears(int $years): Clock
    {
        return $this->modify("-{$years} years");
    }

    public function plusDays(int $days): Clock
    {
        return $this->modify("+{$days} days");
    }

    public function plusHours(int $hours): Clock
    {
        return $this->modifyWithDstChangeSupport("+{$hours} hours");
    }

    public function plusMinutes(int $minutes): Clock
    {
        return $this->modifyWithDstChangeSupport("+{$minutes} minutes");
    }

    public function plusMonths(int $months): Clock
    {
        return $this->modifyMonths("+{$months} months");
    }

    public function plusSeconds(int $seconds): Clock
    {
        return $this->modifyWithDstChangeSupport("+{$seconds} seconds");
    }

    public function plusYears(int $years): Clock
    {
        return $this->modify("+{$years} years");
    }

    public function isAfter(Clock $other): bool
    {
        return $this->getTimestamp() > $other->getTimestamp();
    }

    public function isBefore(Clock $other): bool
    {
        return $this->getTimestamp() < $other->getTimestamp();
    }

    public function isAfterOrEqualTo(Clock $other): bool
    {
        return $this->getTimestamp() >= $other->getTimestamp();
    }

    public function isBeforeOrEqualTo(Clock $other): bool
    {
        return $this->getTimestamp() <= $other->getTimestamp();
    }

    public function withTimezone(DateTimeZone|string $timezone): Clock
    {
        $dateTime = clone $this->dateTime;
        $dateTime->setTimezone(is_string($timezone) ? new DateTimeZone($timezone) : $timezone);
        return new Clock($dateTime);
    }

    private function getTimezone(): DateTimeZone
    {
        return $this->dateTimeZone;
    }
}
