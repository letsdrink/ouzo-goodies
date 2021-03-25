<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\ToString;

use ReflectionClass;

class ToStringBuilder
{
    private ToStringStyle $toStringStyle;

    private string $buffer = '';

    public function __construct(
        private object $object,
        ToStringStyle $style = null
    )
    {
        $this->toStringStyle = $style ?: ToStringStyle::defaultStyle();

        $this->toStringStyle->appendStart($this->buffer, new ReflectionClass($object));
    }

    public function append(string $string, mixed $value): static
    {
        $this->toStringStyle->append($this->buffer, $string, $value);
        return $this;
    }

    public function toString(): string
    {
        $this->toStringStyle->appendEnd($this->buffer);
        return $this->buffer;
    }
}
