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
    public static $freeze = false;
    public static $freezeDate;

    public $dateTime;

    public function __construct(DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
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
        }
        return new Clock($date);
    }

    /**
     * Obtains a Clock set to to a specific point.
     * @param $date
     * @return Clock
     */
    public static function at($date)
    {
        return new Clock(new DateTime($date));
    }

    /**
     * Obtains a Clock set to to a specific point using Unix timestamp.
     * @param $timestamp
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

    private function _modify($interval)
    {
        return new Clock($this->dateTime->modify($interval));
    }

    public function minusDays($days)
    {
        return $this->_modify("-$days days");
    }

    public function minusHours($hours)
    {
        return $this->_modify("-$hours hours");
    }

    public function minusMinutes($minutes)
    {
        return $this->_modify("-$minutes minutes");
    }

    public function minusMonths($months)
    {
        return $this->_modify("-$months months");
    }

    public function minusSeconds($seconds)
    {
        return $this->_modify("-$seconds seconds");
    }

    public function minusYears($years)
    {
        return $this->_modify("-$years years");
    }

    public function plusDays($days)
    {
        return $this->_modify("+$days days");
    }

    public function plusHours($hours)
    {
        return $this->_modify("+$hours hours");
    }

    public function plusMinutes($minutes)
    {
        return $this->_modify("+$minutes minutes");
    }

    public function plusMonths($months)
    {
        return $this->_modify("+$months months");
    }

    public function plusSeconds($seconds)
    {
        return $this->_modify("+$seconds seconds");
    }

    public function plusYears($years)
    {
        return $this->_modify("+$years years");
    }

    public function isAfter($other)
    {
        return $this->getTimestamp() > $other->getTimestamp();
    }

    public function isBefore($other)
    {
        return $this->getTimestamp() < $other->getTimestamp();
    }

    public function setTimezone($timezone)
    {
        $this->dateTime->setTimezone(new DateTimeZone($timezone));
        return $this;
    }
}
