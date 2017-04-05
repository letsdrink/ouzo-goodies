<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

use DateTime;
use DateTimeZone;

/**
 * Class Clock
 * @package Ouzo\Utilities
 */
class Clock
{
    /** @var bool */
    public static $freeze = false;

    /** @var DateTime|Clock */
    public static $freezeDate;

    /** @var DateTime */
    public $dateTime;

    /** @var DateTimeZone */
    private $dateTimeZone;

    public function __construct(DateTime $dateTime)
    {
        $this->dateTime = clone $dateTime;
        $this->dateTimeZone = $dateTime->getTimezone();
    }

    /**
     * Freezes time to a specific point or current time if no time is given.
     *
     * @param null $date
     */
    public static function freeze($date = null)
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
     *
     * @param string $format
     * @return string
     */
    public static function nowAsString($format = null)
    {
        return self::now()->format($format);
    }

    /**
     * Obtains a Clock set to the current time.
     * @return Clock
     */
    public static function now()
    {
        $date = new DateTime();
        if (self::$freeze) {
            $date->setTimestamp(self::$freezeDate->getTimestamp());
            $date->setTimezone(self::$freezeDate->getTimezone());
        }
        return new Clock($date);
    }

    /**
     * Obtains a Clock set to to a specific point.
     * @param string $date
     * @return Clock
     */
    public static function at($date)
    {
        $dateTime = new DateTime($date);
        return new Clock($dateTime);
    }

    /**
     * Obtains a Clock set to to a specific point using Unix timestamp.
     * @param int $timestamp
     * @return Clock
     */
    public static function fromTimestamp($timestamp)
    {
        $dateTime = new DateTime();
        $dateTime->setTimestamp($timestamp);
        return new Clock($dateTime);
    }

    public function getTimestamp()
    {
        return $this->dateTime->getTimestamp();
    }

    public function format($format = null)
    {
        $format = $format ?: 'Y-m-d H:i:s';
        return $this->dateTime->format($format);
    }

    /**
     * Converts this object to a DateTime
     *
     * @return DateTime
     */
    public function toDateTime()
    {
        return $this->dateTime;
    }

    private function modify($interval)
    {
        $dateTime = clone $this->dateTime;
        return new Clock($dateTime->modify($interval));
    }

    private function modifyWithDstChangeSupport($interval)
    {
        $dateTime = clone $this->dateTime;
        $dateTimeZone = new DateTimeZone('GMT');
        return new Clock($dateTime->setTimezone($dateTimeZone)->modify($interval)->setTimezone($this->dateTimeZone));
    }

    private function modifyMonths($interval)
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

    public function minusDays($days)
    {
        return $this->modify("-$days days");
    }

    public function minusHours($hours)
    {
        return $this->modifyWithDstChangeSupport("-$hours hours");
    }

    public function minusMinutes($minutes)
    {
        return $this->modifyWithDstChangeSupport("-$minutes minutes");
    }

    public function minusMonths($months)
    {
        return $this->modifyMonths("-$months months");
    }

    public function minusSeconds($seconds)
    {
        return $this->modifyWithDstChangeSupport("-$seconds seconds");
    }

    public function minusYears($years)
    {
        return $this->modify("-$years years");
    }

    public function plusDays($days)
    {
        return $this->modify("+$days days");
    }

    public function plusHours($hours)
    {
        return $this->modifyWithDstChangeSupport("+$hours hours");
    }

    public function plusMinutes($minutes)
    {
        return $this->modifyWithDstChangeSupport("+$minutes minutes");
    }

    public function plusMonths($months)
    {
        return $this->modifyMonths("+$months months");
    }

    public function plusSeconds($seconds)
    {
        return $this->modifyWithDstChangeSupport("+$seconds seconds");
    }

    public function plusYears($years)
    {
        return $this->modify("+$years years");
    }

    public function isAfter(Clock $other)
    {
        return $this->getTimestamp() > $other->getTimestamp();
    }

    public function isBefore(Clock $other)
    {
        return $this->getTimestamp() < $other->getTimestamp();
    }

    public function isAfterOrEqualTo(Clock $other)
    {
        return $this->getTimestamp() >= $other->getTimestamp();
    }

    public function isBeforeOrEqualTo(Clock $other)
    {
        return $this->getTimestamp() <= $other->getTimestamp();
    }

    /**
     * @param string|DateTimeZone $timezone
     * @return Clock
     */
    public function withTimezone($timezone)
    {
        $dateTime = clone $this->dateTime;
        $dateTime->setTimezone(is_string($timezone) ? new DateTimeZone($timezone) : $timezone);
        return new Clock($dateTime);
    }

    /**
     * @return DateTimeZone
     */
    private function getTimezone()
    {
        return $this->dateTimeZone;
    }
}
