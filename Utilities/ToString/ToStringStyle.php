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
    /** @var bool */
    private $useFieldNames = true;
    /** @var bool */
    private $useShortClassName = false;
    /** @var bool */
    private $useClassName = true;
    /** @var string */
    private $contentStart = '[';
    /** @var string */
    private $contentEnd = ']';
    /** @var string */
    private $fieldNameValueSeparator = '=';
    /** @var bool */
    private $fieldSeparatorAtStart = false;
    /** @var string */
    private $fieldSeparator = ',';
    /** @var string */
    private $arrayStart = '{';
    /** @var string */
    private $arraySeparator = ',';
    /** @var string */
    private $arrayEnd = '}';
    /** @var string */
    private $nullText = '<null>';
    /** @var string */
    private $booleanTrueText = 'true';
    /** @var string */
    private $booleanFalseText = 'false';

    /**
     * @return ToStringStyle
     */
    public static function defaultStyle()
    {
        return new DefaultToStringStyle();
    }

    /**
     * @return ToStringStyle
     */
    public static function noFieldNamesStyle()
    {
        return new NoFieldNameToStringStyle();
    }

    /**
     * @return ToStringStyle
     */
    public static function shortPrefixStyle()
    {
        return new ShortPrefixToStringStyle();
    }

    /**
     * @return ToStringStyle
     */
    public static function simpleStyle()
    {
        return new SimpleToStringStyle();
    }

    /**
     * @return ToStringStyle
     */
    public static function noClassNameStyle()
    {
        return new NoClassNameToStringStyle();
    }

    /**
     * @return ToStringStyle
     */
    public static function multiLineStyle()
    {
        return new MultiLineToStringStyle();
    }

    /**
     * @param string $buffer
     * @param ReflectionClass $object
     */
    public function appendStart(&$buffer, ReflectionClass $object)
    {
        $this->appendClassName($buffer, $object);
        $buffer .= $this->contentStart;
        if ($this->fieldSeparatorAtStart) {
            $buffer .= $this->fieldSeparator;
        }
    }

    /**
     * @param string $buffer
     * @param string $field
     * @param mixed $value
     */
    public function append(&$buffer, $field, $value)
    {
        $this->appendFiledStart($buffer, $field);
        $this->appendValue($buffer, $value);
        $buffer .= $this->fieldSeparator;
    }

    /**
     * @param string $buffer
     */
    public function appendEnd(&$buffer)
    {
        $buffer = rtrim($buffer, $this->fieldSeparator);
        $buffer .= $this->contentEnd;
    }

    /**
     * @param string $buffer
     * @param ReflectionClass $object
     */
    private function appendClassName(&$buffer, ReflectionClass $object)
    {
        if ($this->useClassName) {
            if ($this->useShortClassName) {
                $buffer .= $object->getShortName();
            } else {
                $buffer .= $object->getName();
            }
        }
    }

    /**
     * @param string $buffer
     * @param string $field
     */
    private function appendFiledStart(&$buffer, $field)
    {
        if ($this->useFieldNames) {
            $buffer .= $field;
            $buffer .= $this->fieldNameValueSeparator;
        }
    }

    /**
     * @param string $buffer
     * @param mixed $value
     */
    private function appendValue(&$buffer, $value)
    {
        switch (gettype($value)) {
            case 'boolean':
                $value = $value ? $this->booleanTrueText : $this->booleanFalseText;
                break;
            case 'array':
                $tmp = $this->arrayStart;
                if (Arrays::isAssociative($value)) {
                    $mapKeyToValue = Arrays::mapEntries($value, function ($k, $v) {
                        return $k . '=' . $v;
                    });
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

    /**
     * @param bool $useFieldNames
     */
    protected function setUseFieldNames($useFieldNames)
    {
        $this->useFieldNames = $useFieldNames;
    }

    /**
     * @param bool $useShortClassName
     */
    protected function setUseShortClassName($useShortClassName)
    {
        $this->useShortClassName = $useShortClassName;
    }

    /**
     * @param bool $useClassName
     */
    protected function setUseClassName($useClassName)
    {
        $this->useClassName = $useClassName;
    }

    /**
     * @return string
     */
    protected function getContentStart()
    {
        return $this->contentStart;
    }

    /**
     * @param string $contentStart
     */
    protected function setContentStart($contentStart)
    {
        $this->contentStart = $contentStart;
    }

    /**
     * @return string
     */
    protected function getContentEnd()
    {
        return $this->contentEnd;
    }

    /**
     * @param string $contentEnd
     */
    protected function setContentEnd($contentEnd)
    {
        $this->contentEnd = $contentEnd;
    }

    /**
     * @param string $fieldSeparator
     */
    protected function setFieldSeparator($fieldSeparator)
    {
        $this->fieldSeparator = $fieldSeparator;
    }

    /**
     * @param bool $fieldSeparatorAtStart
     */
    public function setFieldSeparatorAtStart($fieldSeparatorAtStart)
    {
        $this->fieldSeparatorAtStart = $fieldSeparatorAtStart;
    }
}
