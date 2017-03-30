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
    /** @var array */
    private $actual;
    /** @var string */
    private $actualString;

    /**
     * @param array $actual
     */
    private function __construct(array $actual)
    {
        $this->actual = $actual;
        $this->actualString = Objects::toString($actual);
    }

    /**
     * @param array $actual
     * @return ArrayAssert
     */
    public static function that(array $actual)
    {
        return new ArrayAssert($actual);
    }

    /**
     * @param array $selectors
     * @return ArrayAssert
     */
    public function extracting(...$selectors)
    {
        $actual = [];
        if (count($selectors) == 1) {
            $selector = Arrays::first($selectors);
            $actual = Arrays::map($this->actual, Functions::extractExpression($selector, true));
        } else {
            foreach ($this->actual as $item) {
                $extracted = [];
                foreach ($selectors as $selector) {
                    $extracted[] = Functions::call(Functions::extractExpression($selector, true), $item);
                }
                $actual[] = $extracted;
            }
        }
        return self::that($actual);
    }

    /**
     * @return ArrayAssert
     */
    public function keys()
    {
        return new ArrayAssert(array_keys($this->actual));
    }

    /**
     * @param array $elements
     * @return $this
     */
    public function contains(...$elements)
    {
        $this->isNotNull();

        $nonExistingElements = $this->findNonExistingElements($elements);

        $nonExistingString = Objects::toString($nonExistingElements);

        if (!empty($nonExistingElements)) {
            AssertAdapter::failWithDiff("Cannot find expected {$nonExistingString} in actual {$this->actualString}",
                $elements,
                $this->actual,
                $nonExistingString,
                $this->actualString
            );
        }

        return $this;
    }

    /**
     * @param array $elements
     * @return $this
     */
    public function containsOnly(...$elements)
    {
        $this->isNotNull();

        $found = sizeof($elements) - sizeof($this->findNonExistingElements($elements));

        $elementsString = Objects::toString($elements);

        if (sizeof($elements) > sizeof($this->actual) || sizeof($this->actual) > $found) {
            AssertAdapter::failWithDiff("Expected only $elementsString elements in actual {$this->actualString}",
                $elements,
                $this->actual,
                $elementsString,
                $this->actualString
            );
        }

        if (sizeof($elements) < sizeof($this->actual) || sizeof($this->actual) < $found) {
            AssertAdapter::failWithDiff("There are more in expected $elementsString than in actual {$this->actualString}",
                $elements,
                $this->actual,
                $elementsString,
                $this->actualString
            );
        }
        return $this;
    }

    /**
     * @param array $elements
     * @return array
     */
    private function findNonExistingElements(array $elements)
    {
        $nonExistingElements = [];
        foreach ($elements as $element) {
            if (!Arrays::contains($this->actual, $element)) {
                $nonExistingElements[] = $element;
            }
        }
        return $nonExistingElements;
    }

    /**
     * @param array $elements
     * @return $this
     */
    public function containsExactly(...$elements)
    {
        $this->isNotNull();

        $found = 0;
        $min = min(sizeof($this->actual), sizeof($elements));
        for ($i = 0; $i < $min; $i++) {
            if (Objects::equal($this->actual[$i], $elements[$i])) {
                $found++;
            }
        }
        $elementsString = Objects::toString($elements);
        if (sizeof($elements) != $found || sizeof($this->actual) != $found) {
            AssertAdapter::failWithDiff("Elements from expected $elementsString were not found in actual {$this->actualString} or have different order",
                $elements,
                $this->actual,
                $elementsString,
                $this->actualString
            );
        }
        return $this;
    }

    /**
     * @param int $expectedSize
     * @return $this
     */
    public function hasSize($expectedSize)
    {
        $this->isNotNull();
        $actualSize = sizeof($this->actual);
        AssertAdapter::assertEquals($expectedSize, $actualSize, "Expected size $expectedSize, but is $actualSize.\nActual: " . $this->actualString);
        return $this;
    }

    /**
     * @return $this
     */
    public function isNotNull()
    {
        AssertAdapter::assertNotNull($this->actual, "Object is null");
        return $this;
    }

    /**
     * @return $this
     */
    public function isEmpty()
    {
        $this->isNotNull();
        AssertAdapter::assertEmpty($this->actual, "Object should be empty, but is: {$this->actualString}");
        return $this;
    }

    /**
     * @return $this
     */
    public function isNotEmpty()
    {
        $this->isNotNull();
        AssertAdapter::assertNotEmpty($this->actual, "Object is empty");
        return $this;
    }

    /**
     * @param string $property
     * @return ArrayAssert
     */
    public function onProperty($property)
    {
        return new ArrayAssert(Arrays::map($this->actual, Functions::extractExpression($property, true)));
    }

    /**
     * @param string $method
     * @return ArrayAssert
     */
    public function onMethod($method)
    {
        return new ArrayAssert(Arrays::map($this->actual, function ($element) use ($method) {
            return $element->$method();
        }));
    }

    /**
     * @param array $elements
     * @return $this
     */
    public function containsKeyAndValue(array $elements)
    {
        $contains = array_intersect_key($this->actual, $elements);
        $elementsString = Objects::toString($elements);
        AssertAdapter::assertEquals($elements, $contains, "Cannot find key value pairs {$elementsString} in actual {$this->actualString}");
        return $this;
    }

    /**
     * @param array $elements
     * @return $this
     */
    public function containsSequence(...$elements)
    {
        $result = false;
        $size = count($this->actual) - count($elements) + 1;
        for ($i = 0; $i < $size; ++$i) {
            if (Objects::equal(array_slice($this->actual, $i, count($elements)), $elements)) {
                $result = true;
            }
        }
        AssertAdapter::assertTrue($result, "Sequence doesn't match array");
        return $this;
    }

    /**
     * @param array $elements
     * @return $this
     */
    public function excludes(...$elements)
    {
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

    /**
     * @param array $array
     * @return $this
     */
    public function hasEqualKeysRecursively(array $array)
    {
        $currentArrayFlatten = array_keys(Arrays::flattenKeysRecursively($this->actual));
        $arrayFlatten = array_keys(Arrays::flattenKeysRecursively($array));
        AssertAdapter::assertSame(array_diff($currentArrayFlatten, $arrayFlatten), array_diff($arrayFlatten, $currentArrayFlatten));
        return $this;
    }

    /**
     * @param mixed $array
     * @return void
     */
    public function isEqualTo($array)
    {
        AssertAdapter::assertEquals($array, $this->actual);
    }
}
