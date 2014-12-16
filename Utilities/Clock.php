<?php
namespace Ouzo\Utilities;

use DateTime;

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
     * Freeze clock on given date, if given null or none freeze on now.
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
     * Return format date which is currently freeze.
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
     * Return DateTime object which is currently freeze.
     *
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

    public static function at($date)
    {
        return new Clock(new DateTime($date));
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
}
