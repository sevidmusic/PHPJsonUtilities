<?php

require_once(
    __DIR__ .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

class ClassWithReadOnlyProperties{

    public function __construct(private readonly string $foo) {}

    public function foo(): string { return $this->foo; }

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

$reflectionClass = new \ReflectionClass(
    ClassWithReadOnlyProperties::class
);

$propertyName = 'foo';

var_dump(
    "The $propertyName property is not read only: ",
    propertyIsNotReadOnly($propertyName, $reflectionClass)
);

