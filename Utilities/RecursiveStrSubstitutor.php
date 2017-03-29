<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

/**
 * Class RecursiveStrSubstitutor
 * @package Ouzo\Utilities
 */
class RecursiveStrSubstitutor
{
    private $_maxNestLevel;
    private $_substitutor;

    /**
     * Creates recursive substitutor
     * @param array $values
     * @param null|string $default
     * @param int $maxNestLevel
     */
    public function __construct($values = [], $default = null, $maxNestLevel = 10)
    {
        $this->_maxNestLevel = $maxNestLevel;
        $this->_substitutor = new StrSubstitutor($values, $default);
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
     *
     * @param string $string
     * @return mixed
     */
    public function replace($string)
    {
        $nestLevel = 1;
        do {
            $originalString = $string;
            $nestLevel++;
            $string = $this->_substitutor->replace($string);
        } while (($originalString != $string) && ($nestLevel <= $this->_maxNestLevel));
        return $string;
    }
}
