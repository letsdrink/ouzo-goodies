<?php
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
     * Creating proxy for the object.
     * If is given methodHandler class is passed to the created proxy object and all method calls are go over thought those class.
     *
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
            $code .= "function {$method->name}($params) { return call_user_func_array(array(\$this->_methodHandler, __FUNCTION__), func_get_args()); }\n";
        }
        $code .= '}';
        return $code;
    }

    private static function getClassMethods($class)
    {
        $methods = $class->getMethods();
        return Arrays::filter($methods, function (ReflectionMethod $method) {
            return !$method->isConstructor() && !$method->isStatic();
        });
    }

    private static function getParameterDeclaration(ReflectionFunctionAbstract $method)
    {
        return Joiner::on(', ')->join(Arrays::map($method->getParameters(), function (ReflectionParameter $param) {
            $result = '';
            if ($param->getClass()) {
                $result .= $param->getClass()->getName() . ' ';
            }
            if ($param->isArray()) {
                $result .= 'array ';
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

    /**
     * Extract method handler from proxy object.
     *
     * @param $proxy
     * @return mixed
     */
    public static function extractMethodHandler($proxy)
    {
        return $proxy->_methodHandler;
    }
}
