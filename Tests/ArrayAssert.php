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
    private $actual;
    private $actualString;

    private function __construct(array $actual)
    {
        $this->actual = $actual;
        $this->actualString = Objects::toString($actual);
    }

    public static function that(array $actual)
    {
        return new ArrayAssert($actual);
    }

    public function extracting()
    {
        $selectors = func_get_args();
        $actual = array();
        if (count($selectors) == 1) {
            $selector = Arrays::first($selectors);
            $actual = Arrays::map($this->actual, Functions::extractExpression($selector, true));
        } else {
            foreach ($selectors as $selector) {
                $actual[] = Arrays::map($this->actual, Functions::extractExpression($selector, true));
            }
        }
        return self::that($actual);
    }

    public function contains()
    {
        $this->isNotNull();

        $elements = func_get_args();
        $nonExistingElements = $this->findNonExistingElements($elements);

        $nonExistingString = Objects::toString($nonExistingElements);
        AssertAdapter::assertFalse(!empty($nonExistingElements), "Cannot find expected {$nonExistingString} in actual {$this->actualString}");

        return $this;
    }

    public function containsOnly()
    {
        $this->isNotNull();

        $elements = func_get_args();
        $found = sizeof($elements) - sizeof($this->findNonExistingElements($elements));

        $elementsString = Objects::toString($elements);
        AssertAdapter::assertFalse(sizeof($elements) > sizeof($this->actual) || sizeof($this->actual) > $found,
            "Expected only $elementsString elements in actual {$this->actualString}"
        );
        AssertAdapter::assertFalse((sizeof($elements) < sizeof($this->actual) || sizeof($this->actual) < $found),
            "There are more in expected $elementsString than in actual {$this->actualString}"
        );
        return $this;
    }

    private function findNonExistingElements($elements)
    {
        $nonExistingElements = array();
        foreach ($elements as $element) {
            if (!Arrays::contains($this->actual, $element)) {
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
        $min = min(sizeof($this->actual), sizeof($elements));
        for ($i = 0; $i < $min; $i++) {
            if ($this->actual[$i] == $elements[$i]) {
                $found++;
            }
        }
        $elementsString = Objects::toString($elements);
        AssertAdapter::assertFalse(
            (sizeof($elements) != $found || sizeof($this->actual) != $found),
            "Elements from expected $elementsString were not found in actual {$this->actualString} or have different order"
        );
        return $this;
    }

    public function hasSize($expectedSize)
    {
        $this->isNotNull();
        $actualSize = sizeof($this->actual);
        AssertAdapter::assertEquals($expectedSize, $actualSize, "Expected size $expectedSize, but is $actualSize.\nActual: " . $this->actualString);
        return $this;
    }

    public function isNotNull()
    {
        AssertAdapter::assertNotNull($this->actual, "Object is null");
        return $this;
    }

    public function isEmpty()
    {
        $this->isNotNull();
        AssertAdapter::assertEmpty($this->actual, "Object should be empty, but is: {$this->actualString}");
        return $this;
    }

    public function isNotEmpty()
    {
        $this->isNotNull();
        AssertAdapter::assertNotEmpty($this->actual, "Object is empty");
        return $this;
    }

    public function onProperty($property)
    {
        return new ArrayAssert(Arrays::map($this->actual, Functions::extractExpression($property, true)));
    }

    public function onMethod($method)
    {
        return new ArrayAssert(Arrays::map($this->actual, function ($element) use ($method) {
            return $element->$method();
        }));
    }

    public function containsKeyAndValue($elements)
    {
        $contains = array_intersect_key($this->actual, $elements);
        $elementsString = Objects::toString($elements);
        AssertAdapter::assertEquals($elements, $contains, "Cannot find key value pairs {$elementsString} in actual {$this->actualString}");
        return $this;
    }

    public function containsSequence()
    {
        $elements = func_get_args();
        $result = false;
        $size = count($this->actual) - count($elements) + 1;
        for ($i = 0; $i < $size; ++$i) {
            if (array_slice($this->actual, $i, count($elements)) == $elements) {
                $result = true;
            }
        }
        AssertAdapter::assertTrue($result, "Sequence doesn't match array");
        return $this;
    }

    public function excludes()
    {
        $elements = func_get_args();
        $currentArray = $this->actual;
        $foundElement = '';
        $anyFound = Arrays::any($elements, function ($element) use ($currentArray, &$foundElement) {
            $checkInArray = Arrays::contains($currentArray, $element);
            if ($checkInArray) {
                $foundElement = $element;
            }
            return $checkInArray;
        });
        AssertAdapter::assertFalse($anyFound, "Found element {$foundElement} in array {$this->actualString}");
        return $this;
    }

    public function hasEqualKeysRecursively(array $array)
    {
        $currentArrayFlatten = array_keys(Arrays::flattenKeysRecursively($this->actual));
        $arrayFlatten = array_keys(Arrays::flattenKeysRecursively($array));
        AssertAdapter::assertSame(array_diff($currentArrayFlatten, $arrayFlatten), array_diff($arrayFlatten, $currentArrayFlatten));
        return $this;
    }

    public function isEqualTo($array)
    {
        AssertAdapter::assertEquals($array, $this->actual);
    }
}
