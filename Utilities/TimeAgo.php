<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

use DateTime;

/**
 * This class is intended to format date in a "time ago" manner.
 * @package Ouzo\Utilities
 */
class TimeAgo
{
    /** @var string */
    private $date;
    /** @var string */
    private $key;
    /** @var array */
    private $params = [];

    /**
     * @param string $date
     */
    public function __construct($date)
    {
        $this->date = $date;
        $this->prepare();
    }

    /**
     * @return void
     */
    private function prepare()
    {
        $date = new DateTime($this->date);
        if ($this->showJustNow()) {
            $this->key = 'timeAgo.justNow';
            return;
        }
        if ($minutesAgo = $this->showMinutesAgo()) {
            $this->key = 'timeAgo.minAgo';
            $this->params = ['label' => $minutesAgo];
            return;
        }
        if ($this->showTodayAt()) {
            $this->key = 'timeAgo.todayAt';
            $this->params = ['label' => $date->format('H:i')];
            return;
        }
        if ($this->showYesterdayAt()) {
            $this->key = 'timeAgo.yesterdayAt';
            $this->params = ['label' => $date->format('H:i')];
            return;
        }
        if ($this->showThisYear()) {
            $this->key = 'timeAgo.thisYear';
            $this->params = ['day' => $date->format('j'), 'month' => 'timeAgo.month.' . $date->format('n')];
            return;
        }
        $this->key = $date->format('Y-m-d');
    }

    /**
     * @return bool
     */
    private function showJustNow()
    {
        return $this->getDateDiff() <= 60;
    }

    /**
     * @return int|null
     */
    private function showMinutesAgo()
    {
        $difference = $this->getDateDiff();
        return ($difference > 60 && $difference < 3600) ? floor($difference / 60) : null;
    }

    /**
     * @return bool
     */
    private function showTodayAt()
    {
        $difference = $this->getDateDiff();
        return $this->isSameDay() && $difference >= 3600 && $difference < 86400;
    }

    /**
     * @return int
     */
    private function getDateDiff()
    {
        return $this->nowAsTimestamp() - $this->dateAsTimestamp();
    }

    /**
     * @return int
     */
    private function nowAsTimestamp()
    {
        return Clock::now()->getTimestamp();
    }

    /**
     * @return int
     */
    private function dateAsTimestamp()
    {
        return strtotime($this->date);
    }

    /**
     * @return bool
     */
    private function isSameDay()
    {
        $now = $this->nowAsTimestamp();
        $date = $this->dateAsTimestamp();
        return date('Y-m-d', $now) == date('Y-m-d', $date);
    }

    /**
     * @return bool
     */
    private function showYesterdayAt()
    {
        $now = $this->nowAsTimestamp();
        $date = $this->dateAsTimestamp();
        if (date('Y-m', $now) == date('Y-m', $date)) {
            return date('d', $now) - date('d', $date) == 1;
        }
        return false;
    }

    /**
     * @return bool
     */
    private function showThisYear()
    {
        $now = $this->nowAsTimestamp();
        $date = $this->dateAsTimestamp();
        return date('Y', $now) == date('Y', $date);
    }

    /**
     * Creates TimeAgo object for passed date.
     *
     * @param string $date
     * @return TimeAgo
     */
    public static function create($date)
    {
        return new self($date);
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}
