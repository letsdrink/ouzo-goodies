<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

use ReflectionClass;
use ReflectionFunctionAbstract;
use ReflectionMethod;
use ReflectionParameter;

/**
 * Class DynamicProxy
 * @package Ouzo\Utilities
 */
class DynamicProxy
{
    private static $counter;

    /**
     * Creates a proxy for the given class.
     * Returned object dispatches method invocations to $methodHandler.
     * @param $className
     * @param $methodHandler
     * @return null
     */
    public static function newInstance($className, $methodHandler)
    {
        $name = 'DynamicProxy_' . str_replace('\\', '_', $className) . '_' . uniqid() . '_' . self::$counter++;
        eval(self::getProxyClassDefinition($name, $className));
        $object = null;
        eval("\$object = new $name(\$methodHandler);");
        return $object;
    }

    private static function getProxyClassDefinition($name, $className)
    {
        $class = new ReflectionClass($className);
        $relation = $class->isInterface() ? 'implements' : 'extends';

        $code = "class {$name} $relation $className { public \$_methodHandler;\n";
        $code .= "function __construct(\$methodHandler) { \$this->_methodHandler = \$methodHandler; }\n";
        foreach (self::getClassMethods($class) as $method) {
            $params = self::getParameterDeclaration($method);
            $modifier = $method->isStatic() ? 'static' : '';
            $return = self::getReturnType($method);
            $returnCastToType = self::getReturnCastToType($method);
            $code .= "$modifier function {$method->name}($params)$return { {$returnCastToType}call_user_func_array(array(\$this->_methodHandler, __FUNCTION__), func_get_args()); }\n";
        }
        $code .= '}';
        return $code;
    }

    /**
     * @param ReflectionClass $class
     * @return ReflectionMethod[]
     */
    private static function getClassMethods(ReflectionClass $class)
    {
        $methods = $class->getMethods();
        return Arrays::filter($methods, function (ReflectionMethod $method) {
            return !$method->isConstructor();
        });
    }

    private static function getParameterDeclaration(ReflectionFunctionAbstract $method)
    {
        return Joiner::on(', ')->join(Arrays::map($method->getParameters(), function (ReflectionParameter $param) {
            $result = '';
            $isPhp71 = version_compare('7.1.0', PHP_VERSION, '<=');
            $hasType = $isPhp71 ? $hasType = $param->hasType() : true;
            if ($hasType || $param->getClass()) {
                if ($param->getClass()) {
                    $result .= $param->getClass()->getName() . ' ';
                } elseif ($isPhp71) {
                    $result .= $param->getType()->getName() . ' ';
                }
            }
            if (!$isPhp71 && $param->isArray()) {
                $result .= 'array ';
            }
            if ($param->isVariadic()) {
                $result .= '... ';
            }
            if ($param->isPassedByReference()) {
                $result .= '&';
            }
            $result .= '$' . $param->name;
            if ($param->isDefaultValueAvailable()) {
                $result .= " = null"; // methodHandler gets only the passed arguments so anything would work here
            }
            return $result;
        }));
    }

    private static function getReturnType(ReflectionFunctionAbstract $method)
    {
        if (version_compare('7.1.0', PHP_VERSION, '<=')) {
            if ($method->hasReturnType()) {
                return ': ' . $method->getReturnType()->getName();
            }
        }
        return '';
    }

    private static function getReturnCastToType(ReflectionFunctionAbstract $method)
    {
        if (version_compare('7.1.0', PHP_VERSION, '<=')) {
            if ($method->hasReturnType() && $method->getReturnType()->isBuiltin()) {
                $name = $method->getReturnType()->getName();
                if ($name != 'void') {
                    return 'return (' . $name . ')';
                }
                return '';
            }
        }
        return 'return ';
    }

    /**
     * Extracts method handler from proxy object.
     *
     * @param $proxy
     * @return mixed
     */
    public static function extractMethodHandler($proxy)
    {
        return $proxy->_methodHandler;
    }
}
