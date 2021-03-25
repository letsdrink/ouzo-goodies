<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

class RecursiveStrSubstitutor
{
    private StrSubstitutor $substitutor;

    public function __construct(array $values = [], ?string $default = null, private int $maxNestLevel = 10)
    {
        $this->substitutor = new StrSubstitutor($values, $default);
    }

    /**
     * Use StrSubstitutor class recursively
     *
     * Example:
     * <code>
     * $strSubstitutor = new RecursiveStrSubstitutor(array('HOST' => '{{URL}}', 'URL' => 'website.foo'));
     * $substituted = $strSubstitutor->replace('Connect with {{HOST}}');
     * </code>
     * Result:
     * <code>
     * Connect with website.foo
     * </code>
     */
    public function replace(string $string): string
    {
        $nestLevel = 1;
        do {
            $originalString = $string;
            $nestLevel++;
            $string = $this->substitutor->replace($string);
        } while (($originalString != $string) && ($nestLevel <= $this->maxNestLevel));
        return $string;
    }
}
