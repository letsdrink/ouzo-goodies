<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Time;

use LogicException;

class Stopwatch
{
    private Ticker $ticker;

    private bool $running = false;
    private int $startedAt;
    private int $elapsedNanos = 0;

    private function __construct(?Ticker $ticker)
    {
        $this->ticker = $ticker ?: new Ticker();
    }

    public static function createUnstarted(?Ticker $ticker = null): self
    {
        return new Stopwatch($ticker);
    }

    public static function createStarted(?Ticker $ticker = null): self
    {
        return self::createUnstarted($ticker)->start();
    }

    public function elapsed(TimeUnit|string $timeUnit): int
    {
        $nanos = $this->elapsedNanos();
        return TimeUnit::of($timeUnit)->convert($nanos, TimeUnit::NANOSECONDS);
    }

    public function isRunning(): bool
    {
        return $this->running;
    }

    public function reset(): self
    {
        $this->elapsedNanos = 0;
        $this->running = false;
        return $this;
    }

    public function stop(): self
    {
        if (!$this->running) {
            throw new LogicException('Stopwatch is already stopped.');
        }
        $this->elapsedNanos = $this->ticker->read() - $this->startedAt;
        $this->running = false;
        return $this;
    }

    public function start(): self
    {
        if ($this->running) {
            throw new LogicException('Stopwatch is already running.');
        }
        $this->startedAt = $this->ticker->read();
        $this->running = true;
        return $this;
    }

    private function elapsedNanos(): int
    {
        return $this->running ? $this->ticker->read() - $this->startedAt : $this->elapsedNanos;
    }
}
