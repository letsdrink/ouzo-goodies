<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

use Ouzo\Tests\Mock\MockInterface;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionUnionType;

/**
 * Class DynamicProxy
 * @package Ouzo\Utilities
 */
class DynamicProxy
{
    private static int $counter = 0;

    /**
     * Creates a proxy for the given class.
     * Returned object dispatches method invocations to $methodHandler.
     */
    public static function newInstance(string $className, ?object $methodHandler): MockInterface
    {
        $name = 'DynamicProxy_' . str_replace('\\', '_', $className) . '_' . uniqid() . '_' . self::$counter++;
        eval(self::getProxyClassDefinition($name, $className));
        $object = null;
        eval("\$object = new {$name}(\$methodHandler);");
        return $object;
    }

    private static function getProxyClassDefinition(string $name, string $className): string
    {
        $reflectionClass = new ReflectionClass($className);
        $extendsClasses = [];
        $implementsInterfaces = [MockInterface::class];
        if ($reflectionClass->isInterface()) {
            $implementsInterfaces[] = $className;
        } else {
            $extendsClasses[] = $className;
        }
        $extends = self::generateRelation('extends', $extendsClasses);
        $implements = self::generateRelation('implements', $implementsInterfaces);
        $code = "class {$name} {$extends} {$implements} {";
        $code .= "public \$methodHandler;\n";
        $code .= "function __construct(\$methodHandler) { \$this->methodHandler = \$methodHandler; }\n";
        foreach (self::getClassMethods($reflectionClass) as $method) {
            $code .= self::generateMethod($method);
        }
        $code .= '}';
        return $code;
    }

    /** @return ReflectionMethod[] */
    private static function getClassMethods(ReflectionClass $reflectionClass): array
    {
        $reflectionMethods = $reflectionClass->getMethods();
        return Arrays::filter($reflectionMethods, function (ReflectionMethod $reflectionMethod) {
            return !$reflectionMethod->isConstructor();
        });
    }

    private static function generateMethod(ReflectionMethod $reflectionMethod): string
    {
        $methodName = $reflectionMethod->name;
        $modifier = $reflectionMethod->isStatic() ? 'static' : '';
        $parameters = self::generateParameters($reflectionMethod);
        $returnTypeInfo = self::getReturnTypeInfo($reflectionMethod);

        $invoke = 'call_user_func_array(array($this->methodHandler, __FUNCTION__), func_get_args());';

        if (is_null($returnTypeInfo)) {
            $methodSignature = "{$modifier} function {$methodName}({$parameters})";
            $methodBody = "return {$invoke}";
        } elseif ($returnTypeInfo['type'] === 'void') {
            $methodSignature = "{$modifier} function {$methodName}({$parameters}): void";
            $methodBody = $invoke;
        } else {
            $type = $returnTypeInfo['type'];

            $needCasting = $returnTypeInfo['builtin'] && $type !== 'mixed';
            $returnStatement = $needCasting ? "return ({$type})" : 'return';
            if ($type != 'mixed' && $returnTypeInfo['nullable']) {
                $nullable = '?';
                $methodBody = "\$result = {$invoke} if (is_null(\$result)) { return \$result; } else { {$returnStatement} \$result; }";
            } else {
                $nullable = '';
                $methodBody = "{$returnStatement} {$invoke}";
            }

            $methodSignature = "{$modifier} function {$methodName}({$parameters}): {$nullable}{$type}";
        }

        return "{$methodSignature} { {$methodBody} }\n";
    }

    private static function generateParameters(ReflectionMethod $reflectionMethod): string
    {
        $parameters = [];
        foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
            $parameter = '';
            if ($reflectionParameter->hasType() && $reflectionParameter->getType() instanceof ReflectionNamedType) {
                $typeName = $reflectionParameter->getType()->getName();
                $nullable = $typeName != 'mixed' && $reflectionParameter->allowsNull() ? '?' : '';
                $parameter .= "{$nullable}{$typeName} ";
            }
            if ($reflectionParameter->isVariadic()) {
                $parameter .= '...';
            }
            if ($reflectionParameter->isPassedByReference()) {
                $parameter .= '&';
            }
            $parameter .= "\${$reflectionParameter->getName()}";
            if ($reflectionParameter->isDefaultValueAvailable()) {
                $parameter .= ' = null'; // methodHandler gets only the passed arguments so anything would work here
            }
            $parameters[] = $parameter;
        }

        return Joiner::on(', ')->join($parameters);
    }

    private static function getReturnTypeInfo(ReflectionMethod $reflectionMethod): ?array
    {
        if ($reflectionMethod->hasReturnType()) {
            $methodReturnType = $reflectionMethod->getReturnType();
            if ($methodReturnType instanceof ReflectionUnionType) {
                $type = implode('|', Arrays::map($methodReturnType->getTypes(), fn($type) => $type->getName()));
                return [
                    'type' => $type,
                    'builtin' => false,
                    'nullable' => $methodReturnType->allowsNull(),
                ];
            }
            return [
                'type' => $methodReturnType->getName(),
                'builtin' => $methodReturnType->isBuiltin(),
                'nullable' => $methodReturnType->allowsNull(),
            ];
        }

        return null;
    }

    public static function extractMethodHandler(MockInterface $proxy): object
    {
        return $proxy->methodHandler;
    }

    private static function generateRelation(string $relation, array $classes): string
    {
        if ($classes) {
            return $relation . ' ' . implode(', ', $classes);
        }
        return '';
    }
}
