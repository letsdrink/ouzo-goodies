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
    private string $actualString;

    private function __construct(private ?array $actual)
    {
        $this->actualString = Objects::toString($actual);
    }

    public static function that(?array $actual): ArrayAssert
    {
        return new ArrayAssert($actual);
    }

    public function extracting(...$selectors): ArrayAssert
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

    public function keys(): ArrayAssert
    {
        return new ArrayAssert(array_keys($this->actual));
    }

    public function contains(mixed ...$elements): ArrayAssert
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

    public function containsOnly(mixed ...$elements): ArrayAssert
    {
        $this->isNotNull();

        $found = sizeof($elements) - sizeof($this->findNonExistingElements($elements));

        $elementsString = Objects::toString($elements);

        if (sizeof($elements) > sizeof($this->actual) || sizeof($this->actual) > $found) {
            AssertAdapter::failWithDiff("Expected only {$elementsString} elements in actual {$this->actualString}",
                $elements,
                $this->actual,
                $elementsString,
                $this->actualString
            );
        }

        if (sizeof($elements) < sizeof($this->actual) || sizeof($this->actual) < $found) {
            AssertAdapter::failWithDiff("There are more in expected {$elementsString} than in actual {$this->actualString}",
                $elements,
                $this->actual,
                $elementsString,
                $this->actualString
            );
        }
        return $this;
    }

    private function findNonExistingElements(array $elements): array
    {
        $nonExistingElements = [];
        foreach ($elements as $element) {
            if (!Arrays::contains($this->actual, $element)) {
                $nonExistingElements[] = $element;
            }
        }
        return $nonExistingElements;
    }

    public function containsExactly(mixed ...$elements): ArrayAssert
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
            AssertAdapter::failWithDiff("Elements from expected {$elementsString} were not found in actual {$this->actualString} or have different order",
                $elements,
                $this->actual,
                $elementsString,
                $this->actualString
            );
        }
        return $this;
    }

    public function hasSize(int $expectedSize): ArrayAssert
    {
        $this->isNotNull();
        $actualSize = sizeof($this->actual);
        AssertAdapter::assertEquals($expectedSize, $actualSize, "Expected size {$expectedSize}, but is {$actualSize}.\nActual: {$this->actualString}");
        return $this;
    }

    public function isNotNull(): ArrayAssert
    {
        AssertAdapter::assertNotNull($this->actual, "Object is null");
        return $this;
    }

    public function isEmpty(): ArrayAssert
    {
        $this->isNotNull();
        AssertAdapter::assertEmpty($this->actual, "Object should be empty, but is: {$this->actualString}");
        return $this;
    }

    public function isNotEmpty(): ArrayAssert
    {
        $this->isNotNull();
        AssertAdapter::assertNotEmpty($this->actual, 'Object is empty');
        return $this;
    }

    public function onProperty(string $property): ArrayAssert
    {
        return new ArrayAssert(Arrays::map($this->actual, Functions::extractExpression($property, true)));
    }

    public function onMethod(string $method): ArrayAssert
    {
        return new ArrayAssert(Arrays::map($this->actual, fn($element) => $element->$method()));
    }

    public function containsKeyAndValue(array $elements): ArrayAssert
    {
        $contains = array_intersect_key($this->actual, $elements);
        $elementsString = Objects::toString($elements);
        AssertAdapter::assertEquals($elements, $contains, "Cannot find key value pairs {$elementsString} in actual {$this->actualString}");
        return $this;
    }

    public function containsSequence(mixed ...$elements): ArrayAssert
    {
        $contains = $this->doesContainSequence($elements);
        AssertAdapter::assertTrue($contains, "Sequence doesn't match array");
        return $this;
    }

    private function doesContainSequence(array $elements): bool
    {
        $expectedLength = count($elements);
        $size = count($this->actual) - $expectedLength + 1;
        for ($offset = 0; $offset < $size; ++$offset) {
            if (Objects::equal(array_slice($this->actual, $offset, $expectedLength), $elements)) {
                return true;
            }
        }
        return false;
    }

    public function excludes(mixed ...$elements): ArrayAssert
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

    public function hasEqualKeysRecursively(array $array): ArrayAssert
    {
        $currentArrayFlatten = array_keys(Arrays::flattenKeysRecursively($this->actual));
        $arrayFlatten = array_keys(Arrays::flattenKeysRecursively($array));
        AssertAdapter::assertSame(array_diff($currentArrayFlatten, $arrayFlatten), array_diff($arrayFlatten, $currentArrayFlatten));
        return $this;
    }

    public function isEqualTo(mixed $array): void
    {
        AssertAdapter::assertEquals($array, $this->actual);
    }
}
