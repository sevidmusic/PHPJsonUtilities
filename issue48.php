<?php

require_once(
    __DIR__ .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPTextTypes\classes\strings\ClassString;

class ClassWithReadOnlyProperties{

    public function __construct(private readonly string $foo) {}

    public function foo(): string { return $this->foo; }

}

/**
 * Set the value of the specified property via reflection.
 *
 * @param ReflectionClass<object> $reflectionClass
 *
 *
 */
function assignNewPropertyValue(
    string $propertyName,
    mixed $propertyValue,
    object $object,
    Reflection $reflection,
    ReflectionClass $reflectionClass
): void
{
    if($reflectionClass->hasProperty($propertyName)) {
        if(
            propertyIsNotReadOnly(
                $propertyName,
                $reflectionClass
            )
            &&
            !is_null($propertyValue)
        ) {
            $acceptedTypes =
                $reflection->propertyTypes();
            $property =
                $reflectionClass->getProperty(
                    $propertyName
                );
            $property->setAccessible(true);
            $property->setValue(
                $object,
                $propertyValue
            );
        }
    }
}

/**
 * Determine if a property is defined as readonly.
 *
 * @param $propertyName The name of the property to check.
 *
 * @param ReflectionClass<object> $reflectionClass
 */
function propertyIsNotReadOnly(
    string $propertyName,
    ReflectionClass $reflectionClass
): ?bool
{
    if($reflectionClass->hasProperty($propertyName)) {
        $propertyReflection = new ReflectionProperty(
            $reflectionClass->name,
            $propertyName
        );
        return !$propertyReflection->isReadOnly();
    }
    return null;
}

$propertyName = 'foo';
$originalPropertyValue = 'bar';
$newPropertyValue = 'baz';
$instance = new ClassWithReadOnlyProperties($originalPropertyValue);
$reflection = new Reflection(new ClassString($instance));

assignNewPropertyValue(
    $propertyName,
    $newPropertyValue,
    $instance,
    $reflection,
    $reflection->reflectionClass(),
);

var_dump($instance->foo());

$propertyName = 'name';
$originalPropertyValue = Reflection::class;
$newPropertyValue = ClassWithReadOnlyProperties::class;
$instance = new ReflectionClass($originalPropertyValue);
$reflection = new Reflection(new ClassString($instance));

assignNewPropertyValue(
    $propertyName,
    $newPropertyValue,
    $instance,
    $reflection,
    $reflection->reflectionClass(),
);

var_dump($instance->name);

