<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests\Mock;

use Ouzo\Utilities\FluentFunction;
use Ouzo\Utilities\Functions;

class FluentArgumentMatcher extends FluentFunction implements ArgumentMatcher
{
    private $description = 'argThat()';

    public function matches($argument)
    {
        return Functions::call($this, $argument);
    }

    public function __call($name, $arguments)
    {
        parent::__call($name, $arguments);
        $this->description .= '->';
        $this->description .= MethodCall::newInstance($name, $arguments)->toString();
        return $this;
    }

    public function __toString()
    {
        return $this->description;
    }
}
