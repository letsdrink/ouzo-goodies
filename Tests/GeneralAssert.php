<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests;

class GeneralAssert
{
    /** @var mixed */
    private $actual;

    /**
     * @param mixed $actual
     */
    private function __construct($actual)
    {
        $this->actual = $actual;
    }

    /**
     * @param mixed $actual
     * @return GeneralAssert
     */
    public static function that($actual)
    {
        return new GeneralAssert($actual);
    }

    /**
     * @param mixed $object
     * @return $this
     */
    public function isEqualTo($object)
    {
        AssertAdapter::assertEquals($object, $this->actual);
        return $this;
    }

    /**
     * @param string $className
     * @return $this
     */
    public function isInstanceOf($className)
    {
        AssertAdapter::assertInstanceOf($className, $this->actual);
        return $this;
    }

    /**
     * @return $this
     */
    public function isNull()
    {
        AssertAdapter::assertNull($this->actual);
        return $this;
    }

    /**
     * @return $this
     */
    public function isNotNull()
    {
        AssertAdapter::assertNotNull($this->actual);
        return $this;
    }
}
