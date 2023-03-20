
```
   ___  __ _____     __              __  ____  _ ___ __  _
  / _ \/ // / _ \__ / /__ ___  ___  / / / / /_(_) (_) /_(_)__ ___
 / ___/ _  / ___/ // (_-</ _ \/ _ \/ /_/ / __/ / / / __/ / -_|_-<
/_/  /_//_/_/   \___/___/\___/_//_/\____/\__/_/_/_/\__/_/\__/___/


             A library for working with json in php


         https://github.com/sevidmusic/PHPJsonUtilities
```

The PHPJsonUtilities library provides classes for working with json
in php.

Note: This library is still under development, it is not ready for use.

# Overview

- [Installation](#installation)

# Installation

```
composer require darling/php-json-utilities
```

# Draft

```
<?php

include('/home/darling/Git/PHPJsonUtilities/vendor/autoload.php');

use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPTextTypes\classes\strings\AlphanumericText;
use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\Name;
use \Darling\PHPTextTypes\classes\strings\SafeText;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Darling\PHPTextTypes\classes\strings\UnknownClass;

class JsonString extends Text
{

    public function __construct(
        private mixed $originalValue,
        private bool $originalValueIsJson = false
    ) {
        $this->encodeOriginalValueAsJson();
    }

    final public function __toString(): string
    {
        $this->encodeOriginalValueAsJson();
        return parent::__toString();
    }

    public function originalValue(): mixed {
        return $this->originalValue;
    }

    public function originalValueIsJson(): mixed {
        return $this->originalValueIsJson;
    }

    final protected function encodeOriginalValueAsJson() : void
    {
        parent::__construct($this->jsonEncode());
    }

    protected function jsonEncode(): string
    {
        return strval(
            is_string($this->originalValue())
            &&
            $this->originalValueIsJson() === true
            &&
            false !== json_decode($this->originalValue())
            ? $this->originalValue()
            : json_encode($this->originalValue())
        );
    }

}

class JsonSerializedObject extends JsonString
{

    public function __construct(
        private object $originalObject
    ) {
        parent::__construct($this->originalObject());
    }

    public function originalObject(): object {
        return  $this->originalObject;
    }

    protected function jsonEncode(): string {
        return $this->encodeObjectAsJson($this->originalObject());
    }


    public const CLASS_INDEX = '__class__';
    public const DATA_INDEX = '__data__';

    private function encodeObjectAsJson(object $object): string
    {
        $data = [];
        $objectReflection = $this->objectReflection($object);
        foreach($objectReflection->propertyValues() as $propertyName => $propertyValue)
        {
            if(is_object($propertyValue)) {
               $data[$propertyName] = $this->encodeObjectAsJson($propertyValue);
               continue;
            }
            $data[$propertyName] = $propertyValue;

        }
        return strval(
            json_encode(
                [
                    self::CLASS_INDEX => $objectReflection->type()->__toString(),
                    self::DATA_INDEX => $data
                ]
            )
        );
    }

    private function objectReflection(object $object): ObjectReflection
    {
        return new ObjectReflection($object);
    }

}

function decodeJsonToObject(JsonString $json): object {
    $data = json_decode($json, true);
    if (
        is_array($data)
        &&
        isset($data[JsonSerializedObject::CLASS_INDEX])
        &&
        isset($data[JsonSerializedObject::DATA_INDEX])
    ) {
        $class = $data[JsonSerializedObject::CLASS_INDEX];
        $reflection = new ReflectionClass($class);
        $object = $reflection->newInstanceWithoutConstructor();
        while ($reflection) {
            foreach ($data[JsonSerializedObject::DATA_INDEX] as $name => $originalValue) {
                if(is_string($originalValue) && (false !== json_decode($originalValue))) {
                    if(
                        str_contains($originalValue, JsonSerializedObject::CLASS_INDEX)
                        &&
                        str_contains($originalValue, JsonSerializedObject::DATA_INDEX)
                    ) {
                        $originalValue = decodeJsonToObject(new JsonString($originalValue, true));
                    }
                }
                if ($reflection->hasProperty($name)) {
                    $property = $reflection->getProperty($name);
                    $property->setAccessible(true);
                    $property->setValue($object, $originalValue);
                }
            }
            $reflection = $reflection->getParentClass();
        }
        return $object;
    }
    return new UnknownClass();
}

$testObjects = [
    new AlphanumericText(new Text('Foo')),
    new Id(),
    new JsonSerializedObject(new JsonString(new Id())),
    new JsonString(new Id()),
    new Name(new Text('Baz')),
    new SafeText(new Text('Bazzer')),
    new Text('Bar'),
    new UnknownClass(),
];

$testObject = $testObjects[array_rand($testObjects)];

$testJsonSerializedObject = new JsonSerializedObject($testObject);

$decodedTestObject = decodeJsonToObject($testJsonSerializedObject);

var_dump('$decodedTestObject matches $testObject', $decodedTestObject == $testObject);

// save json for later viewing/debugging
file_put_contents('/tmp/darlingTestJson.json', $testJsonSerializedObject->__toString());

```
