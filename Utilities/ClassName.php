<?php
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
     * @param $string
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
