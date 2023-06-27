<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

readonly class StrSubstitutor
{
    private const START = '{{';
    private const END = '}}';

    public function __construct(
        private array $values = [],
        private ?string $default = null
    )
    {
    }

    public function replace(?string $string): string
    {
        if (is_null($string)) {
            return Strings::EMPTY;
        }

        $start = preg_quote(self::START);
        $end = preg_quote(self::END);
        return preg_replace_callback("/{$start}(.+?){$end}/u", [$this, 'replaceVars'], $string);
    }

    private function replaceVars(array $match): string
    {
        $matched = $match[0];
        $name = $match[1];
        $default = is_null($this->default) ? $matched : $this->default;
        return $this->values[$name] ?? $default;
    }
}
