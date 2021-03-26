<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

use Closure;

class Joiner
{
    private bool $skipNulls = false;
    private ?Closure $function = null;
    private ?Closure $valuesFunction = null;

    public function __construct(private string $separator)
    {
    }

    /** Returns a Joiner object that uses the given separator. */
    public static function on(string $separator): Joiner
    {
        return new Joiner($separator);
    }

    /** Returns a string containing array elements joined using the previously configured separator. */
    public function join(array $array): string
    {
        $function = $this->function;
        $valuesFunction = $this->valuesFunction;
        $result = '';
        foreach ($array as $key => $value) {
            if (!$this->skipNulls || ($this->skipNulls && $value)) {
                $result .= (
                    $function ? $function($key, $value) :
                        ($valuesFunction ? $valuesFunction($value) : $value)
                    ) . $this->separator;
            }
        }
        return rtrim($result, $this->separator);
    }

    /** Returns a Joiner that skips null elements. */
    public function skipNulls(): static
    {
        $this->skipNulls = true;
        return $this;
    }

    /**
     * Returns a Joiner that transforms array elements before joining.
     * $function is called with two parameters: key and value.
     */
    public function map(callable $function): static
    {
        $this->function = Closure::fromCallable($function);
        return $this;
    }

    /**
     * Returns a Joiner that transforms array values before joining.
     * $function is called with one parameter: value.
     */
    public function mapValues(callable $function): static
    {
        $this->valuesFunction = Closure::fromCallable($function);
        return $this;
    }
}
