<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

/**
 * Class ClassName
 * @package Ouzo\Utilities
 */
class ClassName
{
    /**
     * Transforms path to class name with namespaces.
     *
     * Example:
     * <code>
     * $string = 'api/multiple_ns';
     * $namespace = ClassName::pathToFullyQualifiedName($string);
     * </code>
     * Result:
     * <code>
     * Api\\MultipleNs
     * </code>
     *
     * @param string $string
     * @return string
     */
    public static function pathToFullyQualifiedName($string)
    {
        $parts = explode('/', $string);
        $namespace = '';
        foreach ($parts as $part) {
            $namespace .= Strings::underscoreToCamelCase($part) . '\\';
        }
        return rtrim($namespace, '\\');
    }
}
