<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

use DateTime;

class TimeAgo
{
    private string $key;
    private array $params = [];

    public function __construct(private string $date)
    {
        $this->prepare();
    }

    private function prepare(): void
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

    private function showJustNow(): bool
    {
        return $this->getDateDiff() <= 60;
    }

    private function showMinutesAgo(): ?int
    {
        $difference = $this->getDateDiff();
        return ($difference > 60 && $difference < 3600) ? floor($difference / 60) : null;
    }

    private function showTodayAt(): bool
    {
        $difference = $this->getDateDiff();
        return $this->isSameDay() && $difference >= 3600 && $difference < 86400;
    }

    private function getDateDiff(): int
    {
        return $this->nowAsTimestamp() - $this->dateAsTimestamp();
    }

    private function nowAsTimestamp(): int
    {
        return Clock::now()->getTimestamp();
    }

    private function dateAsTimestamp(): int
    {
        return strtotime($this->date);
    }

    private function isSameDay(): bool
    {
        $now = $this->nowAsTimestamp();
        $date = $this->dateAsTimestamp();
        return date('Y-m-d', $now) == date('Y-m-d', $date);
    }

    private function showYesterdayAt(): bool
    {
        $now = $this->nowAsTimestamp();
        $date = $this->dateAsTimestamp();
        if (date('Y-m', $now) == date('Y-m', $date)) {
            return date('d', $now) - date('d', $date) == 1;
        }
        return false;
    }

    private function showThisYear(): bool
    {
        $now = $this->nowAsTimestamp();
        $date = $this->dateAsTimestamp();
        return date('Y', $now) == date('Y', $date);
    }

    public static function create(string $date): TimeAgo
    {
        return new self($date);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
