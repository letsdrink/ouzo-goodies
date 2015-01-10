<?php
namespace Ouzo\Utilities;

use DateTime;

class TimeAgo
{
    private $_date;

    public $key = null;
    public $params = array();

    public function __construct($date)
    {
        $this->_date = $date;
        $this->prepare();
    }

    private function prepare()
    {
        $date = new DateTime($this->_date);
        if ($this->_showJustNow()) {
            $this->key = 'timeAgo.justNow';
            return;
        }
        if ($minutesAgo = $this->_showMinutesAgo()) {
            $this->key = 'timeAgo.minAgo';
            $this->params = array('label' => $minutesAgo);
            return;
        }
        if ($this->_showTodayAt()) {
            $this->key = 'timeAgo.todayAt';
            $this->params = array('label' => $date->format('H:i'));
            return;
        }
        if ($this->_showYesterdayAt()) {
            $this->key = 'timeAgo.yesterdayAt';
            $this->params = array('label' => $date->format('H:i'));
            return;
        }
        if ($this->_showThisYear()) {
            $this->key = 'timeAgo.thisYear';
            $this->params = array('day' => $date->format('j'), 'month' => 'timeAgo.month.' . $date->format('n'));
            return;
        }
        $this->key = $date->format('Y-m-d');
    }

    private function _showJustNow()
    {
        return $this->_getDateDiff() <= 60;
    }

    private function _showMinutesAgo()
    {
        $difference = $this->_getDateDiff();
        return ($difference > 60 && $difference < 3600) ? floor($difference / 60) : null;
    }

    private function _showTodayAt()
    {
        $difference = $this->_getDateDiff();
        return $this->_isSameDay() && $difference >= 3600 && $difference < 86400;
    }

    private function _getDateDiff()
    {
        return $this->_nowAsTimestamp() - $this->_dateAsTimestamp();
    }

    private function _nowAsTimestamp()
    {
        return Clock::now()->getTimestamp();
    }

    private function _dateAsTimestamp()
    {
        return strtotime($this->_date);
    }

    private function _isSameDay()
    {
        $now = $this->_nowAsTimestamp();
        $date = $this->_dateAsTimestamp();
        return date('Y-m-d', $now) == date('Y-m-d', $date);
    }

    private function _showYesterdayAt()
    {
        $now = $this->_nowAsTimestamp();
        $date = $this->_dateAsTimestamp();
        if (date('Y-m', $now) == date('Y-m', $date)) {
            return date('d', $now) - date('d', $date) == 1;
        }
        return false;
    }

    private function _showThisYear()
    {
        $now = $this->_nowAsTimestamp();
        $date = $this->_dateAsTimestamp();
        return date('Y', $now) == date('Y', $date);
    }

    public static function create($date)
    {
        return new self($date);
    }
}
