<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

class FluentArray
{
    public function __construct(private array $array)
    {
    }

    public static function from(array $array): FluentArray
    {
        return new self($array);
    }

    public function each(callable $function): void
    {
        Arrays::each($this->array, $function);
    }

    public function map(callable $function): static
    {
        $this->array = Arrays::map($this->array, $function);
        return $this;
    }

    public function mapKeys(callable $function): static
    {
        $this->array = Arrays::mapKeys($this->array, $function);
        return $this;
    }

    public function mapEntries(callable $function): static
    {
        $this->array = Arrays::mapEntries($this->array, $function);
        return $this;
    }

    public function filter(callable $function): static
    {
        $this->array = Arrays::filter($this->array, $function);
        return $this;
    }

    public function filterNotBlank(): static
    {
        $this->array = Arrays::filterNotBlank($this->array);
        return $this;
    }

    public function filterByKeys(callable $function): static
    {
        $this->array = Arrays::filterByKeys($this->array, $function);
        return $this;
    }

    public function filterByAllowedKeys(array $allowedKeys): static
    {
        $this->array = Arrays::filterByAllowedKeys($this->array, $allowedKeys);
        return $this;
    }

    public function unique(): static
    {
        $this->array = array_unique($this->array);
        return $this;
    }

    public function uniqueBy(string|Extractor|callable $selector): static
    {
        return $this
            ->toMap(Functions::extractExpression($selector))
            ->values();
    }

    public function groupBy(callable $selector): static
    {
        $this->array = Arrays::groupBy($this->array, $selector);
        return $this;
    }

    public function sort(callable $comparator): static
    {
        $this->array = Arrays::sort($this->array, $comparator);
        return $this;
    }

    public function flip(): static
    {
        $this->array = array_flip($this->array);
        return $this;
    }

    public function keys(): static
    {
        $this->array = Arrays::keys($this->array);
        return $this;
    }

    public function values(): static
    {
        $this->array = Arrays::values($this->array);
        return $this;
    }

    public function flatten(): static
    {
        $this->array = Arrays::flatten($this->array);
        return $this;
    }

    public function intersect(array $array): static
    {
        $this->array = array_intersect($this->array, $array);
        return $this;
    }

    public function reverse(): static
    {
        $this->array = array_reverse($this->array);
        return $this;
    }

    public function toMap(callable $keyFunction, callable $valueFunction = null): static
    {
        $this->array = Arrays::toMap($this->array, $keyFunction, $valueFunction);
        return $this;
    }

    public function toArray(): array
    {
        return $this->array;
    }

    public function firstOr(mixed $default): mixed
    {
        return Arrays::firstOrNull($this->array) ?: $default;
    }

    public function toJson(): string
    {
        return Json::encode($this->array);
    }

    public function limit(int $number): static
    {
        $this->array = array_slice($this->array, 0, $number);
        return $this;
    }

    public function skip(int $number): static
    {
        $this->array = array_slice($this->array, $number);
        return $this;
    }

    public function getDuplicates(): static
    {
        $this->array = Arrays::getDuplicates($this->array);
        return $this;
    }

    public function getDuplicatesAssoc(): static
    {
        $this->array = Arrays::getDuplicatesAssoc($this->array);
        return $this;
    }
}
