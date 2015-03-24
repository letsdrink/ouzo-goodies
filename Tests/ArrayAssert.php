<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Tests;

use Ouzo\Utilities\Arrays;
use Ouzo\Utilities\Functions;
use Ouzo\Utilities\Objects;

class ArrayAssert
{
    private $_actual;
    private $_actualString;

    private function __construct(array $actual)
    {
        $this->_actual = $actual;
        $this->_actualString = Objects::toString($actual);
    }

    public static function that(array $actual)
    {
        return new ArrayAssert($actual);
    }

    public function contains()
    {
        $this->isNotNull();

        $elements = func_get_args();
        $nonExistingElements = $this->_findNonExistingElements($elements);

        $nonExistingString = Objects::toString($nonExistingElements);
        AssertAdapter::assertFalse(!empty($nonExistingElements), "Cannot find expected {$nonExistingString} in actual {$this->_actualString}");

        return $this;
    }

    public function containsOnly()
    {
        $this->isNotNull();

        $elements = func_get_args();
        $found = sizeof($elements) - sizeof($this->_findNonExistingElements($elements));

        $elementsString = Objects::toString($elements);
        AssertAdapter::assertFalse(sizeof($elements) > sizeof($this->_actual) || sizeof($this->_actual) > $found,
            "Expected only $elementsString elements in actual {$this->_actualString}"
        );
        AssertAdapter::assertFalse((sizeof($elements) < sizeof($this->_actual) || sizeof($this->_actual) < $found),
            "There are more in expected $elementsString than in actual {$this->_actualString}"
        );
        return $this;
    }

    private function _findNonExistingElements($elements)
    {
        $nonExistingElements = array();
        foreach ($elements as $element) {
            if (!in_array($element, $this->_actual)) {
                $nonExistingElements[] = $element;
            }
        }
        return $nonExistingElements;
    }

    public function containsExactly()
    {
        $this->isNotNull();

        $elements = func_get_args();
        $found = 0;
        $min = min(sizeof($this->_actual), sizeof($elements));
        for ($i = 0; $i < $min; $i++) {
            if ($this->_actual[$i] == $elements[$i]) {
                $found++;
            }
        }
        $elementsString = Objects::toString($elements);
        AssertAdapter::assertFalse(
            (sizeof($elements) != $found || sizeof($this->_actual) != $found),
            "Elements from expected $elementsString were not found in actual {$this->_actualString} or have different order"
        );
        return $this;
    }

    public function hasSize($expectedSize)
    {
        $this->isNotNull();
        $actualSize = sizeof($this->_actual);
        AssertAdapter::assertEquals($expectedSize, $actualSize, "Expected size $expectedSize, but is $actualSize.\nActual: " . $this->_actualString);
        return $this;
    }

    public function isNotNull()
    {
        AssertAdapter::assertNotNull($this->_actual, "Object is null");
        return $this;
    }

    public function isEmpty()
    {
        $this->isNotNull();
        AssertAdapter::assertEmpty($this->_actual, "Object should be empty, but is: {$this->_actualString}");
        return $this;
    }

    public function isNotEmpty()
    {
        $this->isNotNull();
        AssertAdapter::assertNotEmpty($this->_actual, "Object is empty");
        return $this;
    }

    public function onProperty($property)
    {
        return new ArrayAssert(Arrays::map($this->_actual, Functions::extractExpression($property, true)));
    }

    public function onMethod($method)
    {
        return new ArrayAssert(Arrays::map($this->_actual, function ($element) use ($method) {
            return $element->$method();
        }));
    }

    public function containsKeyAndValue($elements)
    {
        $contains = array_intersect_key($this->_actual, $elements);
        $elementsString = Objects::toString($elements);
        AssertAdapter::assertEquals($elements, $contains, "Cannot find key value pairs {$elementsString} in actual {$this->_actualString}");
        return $this;
    }

    public function containsSequence()
    {
        $elements = func_get_args();
        $result = false;
        $size = count($this->_actual) - count($elements) + 1;
        for ($i = 0; $i < $size; ++$i) {
            if (array_slice($this->_actual, $i, count($elements)) == $elements) {
                $result = true;
            }
        }
        AssertAdapter::assertTrue($result, "Sequence doesn't match array");
        return $this;
    }

    public function excludes()
    {
        $elements = func_get_args();
        $currentArray = $this->_actual;
        $foundElement = '';
        $anyFound = Arrays::any($elements, function ($element) use ($currentArray, &$foundElement) {
            $checkInArray = in_array($element, $currentArray);
            if ($checkInArray) {
                $foundElement = $element;
            }
            return $checkInArray;
        });
        AssertAdapter::assertFalse($anyFound, "Found element {$foundElement} in array {$this->_actualString}");
        return $this;
    }

    public function hasEqualKeysRecursively(array $array)
    {
        $currentArrayFlatten = array_keys(Arrays::flattenKeysRecursively($this->_actual));
        $arrayFlatten = array_keys(Arrays::flattenKeysRecursively($array));
        AssertAdapter::assertSame(array_diff($currentArrayFlatten, $arrayFlatten), array_diff($arrayFlatten, $currentArrayFlatten));
        return $this;
    }

    public function isEqualTo($array)
    {
        AssertAdapter::assertEquals($array, $this->_actual);
    }
}
