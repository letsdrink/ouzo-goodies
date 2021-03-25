<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\ToString;

use Ouzo\Utilities\Arrays;
use ReflectionClass;

abstract class ToStringStyle
{
    private bool $useFieldNames = true;
    private bool $useShortClassName = false;
    private bool $useClassName = true;
    private string $contentStart = '[';
    private string $contentEnd = ']';
    private string $fieldNameValueSeparator = '=';
    private bool $fieldSeparatorAtStart = false;
    private string $fieldSeparator = ',';
    private string $arrayStart = '{';
    private string $arraySeparator = ',';
    private string $arrayEnd = '}';
    private string $nullText = '<null>';
    private string $booleanTrueText = 'true';
    private string $booleanFalseText = 'false';

    public static function defaultStyle(): ToStringStyle
    {
        return new DefaultToStringStyle();
    }

    public static function noFieldNamesStyle(): ToStringStyle
    {
        return new NoFieldNameToStringStyle();
    }

    public static function shortPrefixStyle(): ToStringStyle
    {
        return new ShortPrefixToStringStyle();
    }

    public static function simpleStyle(): ToStringStyle
    {
        return new SimpleToStringStyle();
    }

    public static function noClassNameStyle(): ToStringStyle
    {
        return new NoClassNameToStringStyle();
    }

    public static function multiLineStyle(): ToStringStyle
    {
        return new MultiLineToStringStyle();
    }

    public function appendStart(string &$buffer, ReflectionClass $object): void
    {
        $this->appendClassName($buffer, $object);
        $buffer .= $this->contentStart;
        if ($this->fieldSeparatorAtStart) {
            $buffer .= $this->fieldSeparator;
        }
    }

    public function append(string &$buffer, string $field, mixed $value): void
    {
        $this->appendFiledStart($buffer, $field);
        $this->appendValue($buffer, $value);
        $buffer .= $this->fieldSeparator;
    }

    public function appendEnd(string &$buffer): void
    {
        $buffer = rtrim($buffer, $this->fieldSeparator);
        $buffer .= $this->contentEnd;
    }

    private function appendClassName(string &$buffer, ReflectionClass $object): void
    {
        if ($this->useClassName) {
            if ($this->useShortClassName) {
                $buffer .= $object->getShortName();
            } else {
                $buffer .= $object->getName();
            }
        }
    }

    private function appendFiledStart(string &$buffer, string $field): void
    {
        if ($this->useFieldNames) {
            $buffer .= $field;
            $buffer .= $this->fieldNameValueSeparator;
        }
    }

    private function appendValue(string &$buffer, mixed $value): void
    {
        switch (gettype($value)) {
            case 'boolean':
                $value = $value ? $this->booleanTrueText : $this->booleanFalseText;
                break;
            case 'array':
                $tmp = $this->arrayStart;
                if (Arrays::isAssociative($value)) {
                    $mapKeyToValue = Arrays::mapEntries($value, fn($k, $v) => "{$k}={$v}");
                    $tmp .= implode($this->arraySeparator, $mapKeyToValue);
                } else {
                    $tmp .= implode($this->arraySeparator, $value);
                }
                $tmp .= $this->arrayEnd;
                $value = $tmp;
                break;
            case 'NULL':
                $value = $this->nullText;
                break;
            case 'object':
                $reflectionClass = new ReflectionClass($value);
                if (!$reflectionClass->hasMethod("__toString")) {
                    $value = $reflectionClass->getName();
                }
                break;
        }

        $buffer .= $value;
    }

    protected function setUseFieldNames(bool $useFieldNames): void
    {
        $this->useFieldNames = $useFieldNames;
    }

    protected function setUseShortClassName(bool $useShortClassName): void
    {
        $this->useShortClassName = $useShortClassName;
    }

    protected function setUseClassName(bool $useClassName): void
    {
        $this->useClassName = $useClassName;
    }

    protected function getContentStart(): string
    {
        return $this->contentStart;
    }

    protected function setContentStart(string $contentStart): void
    {
        $this->contentStart = $contentStart;
    }

    protected function getContentEnd(): string
    {
        return $this->contentEnd;
    }

    protected function setContentEnd(string $contentEnd): void
    {
        $this->contentEnd = $contentEnd;
    }

    protected function setFieldSeparator(string $fieldSeparator): void
    {
        $this->fieldSeparator = $fieldSeparator;
    }

    public function setFieldSeparatorAtStart(bool $fieldSeparatorAtStart): void
    {
        $this->fieldSeparatorAtStart = $fieldSeparatorAtStart;
    }
}
