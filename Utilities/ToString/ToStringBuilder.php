<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\ToString;

use ReflectionClass;

class ToStringBuilder
{
    /** @var object */
    private $object;
    /** @var ToStringStyle */
    private $style;
    /** @var string */
    private $buffer = '';

    /**
     * @param object $object
     * @param ToStringStyle|null $object
     */
    public function __construct($object, ToStringStyle $style = null)
    {
        $this->object = $object;
        $this->style = $style ?: ToStringStyle::defaultStyle();

        $this->style->appendStart($this->buffer, new ReflectionClass($object));
    }

    /**
     * @param string $string
     * @param mixed $value
     * @return $this
     */
    public function append($string, $value)
    {
        $this->style->append($this->buffer, $string, $value);

        return $this;
    }

    /**
     * @return string
     */
    public function toString()
    {
        $this->style->appendEnd($this->buffer);

        return $this->buffer;
    }
}
