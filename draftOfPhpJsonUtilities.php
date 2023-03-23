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
use \Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\PrivateMethods;

function dev_dump(string $name, mixed $value): void {
    echo PHP_EOL;
    var_dump(
        '----- ' . $name . ' -----',
        $value,
    );
    echo PHP_EOL;
}

/**
 * This class will not  be apart of this library, it will be
 * apart of astandalone library that will be required by this library.
 *
 * Drafting it here in order to draft this library's classes.
 *
 */
class Mocker extends Reflection
{
     private const ARRAY = 'array';
     private const BOOLEAN = 'bool';
     private const CONSTRUCT = '__construct';
     private const DOUBLE = 'double';
     private const INTEGER = 'integer';
     private const NULL = 'NULL';
     private const STRING = 'string';


     /**
      * [Description]
      *
      * @param class-string|object $class
      *
      * @return ReflectionClass<object>
      *
      * @example
      *
      * ```
      *
      * ```
      *
      */
     public function getClassReflection(
         string|object $class
     ): ReflectionClass
    {
        if(
            class_exists(
                (
                    is_object($class)
                    ? $class::class
                    : $class
                )
            )
        ) {
            return new ReflectionClass($class);
        }
        return new ReflectionClass(new UnknownClass());
    }

    /**
     * [Description]
     *
     * @param class-string|object $class
     *
     * @param array<mixed> $constructorArguments
     *
     * @return object
     *
     * @example
     *
     * ```
     *
     * ```
     *
     */
     public function getClassInstance(
         string|object $class,
         array $constructorArguments = array()
     ): object
     {
        if (method_exists($class, self::CONSTRUCT) === false) {
            try {
                return $this->getClassReflection($class)->newInstanceArgs([]);
            } catch (ReflectionException $e) {
                return $e;
            }
        }
        if (empty($constructorArguments) === true) {
            try {
                return $this->getClassReflection($class)->newInstanceArgs(
                    $this->generateMockClassMethodArguments($class, self::CONSTRUCT)
                );
            } catch (ReflectionException $e) {
                return $e;
            }
        }
        return $this->getClassReflection($class)->newInstanceArgs($constructorArguments);
    }

     /**
      * [Description]
      *
      * @param class-string|object $class
      *
      * @param string $method
      *
      * @return array<mixed>
      *
      * @example
      *
      * ```
      *
      * ```
      *
      */
     public function generateMockClassMethodArguments(
         string|object $class,
         string $method
     ): array
    {
        $reflection = new self($this->getClassReflection($class));
        $defaults = array();
        $id = new Id();
        $randChars = $id->__toString();
        if(method_exists($class, $method)) {
            foreach (
                $reflection->methodParameterTypes($method)
                as
                $name => $types
            ) {
                foreach($types as $type) {
                    if ($type === self::BOOLEAN) {
                        $defaults[$name] = false;
                        continue;
                    }
                    if ($type === self::INTEGER) {
                        $defaults[$name] = 1;
                        continue;
                    }
                    if ($type === self::DOUBLE) {
                        $defaults[$name] = 1.2345;
                        continue;
                    }
                    if ($type === self::STRING) {
                        $defaults[$name] = $randChars;
                        continue;
                    }
                    if ($type === self::ARRAY) {
                        $defaults[$name] = [];
                        continue;
                    }
                    if ($type === self::NULL) {
                        $defaults[$name] = null;
                        continue;
                    }
                    /**
                     * For unknown types assume class instance.
                     * @var class-string<object>|object $type
                     */
                    $type = '\\' . str_replace(
                        ['interfaces'],
                        ['classes'],
                        $type
                    );
                        $defaults[$name] = $reflection->getClassInstance($type);
                    }
            }
        }
        return $defaults;
    }

}

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
                $data[$propertyName] = $this->encodeObjectAsJson(
                    $propertyValue
                );
               continue;
            }
            $data[$propertyName] = $propertyValue;

        }
        return strval(
            json_encode(
                [
                    self::CLASS_INDEX =>
                        $objectReflection->type()->__toString(),
                    self::DATA_INDEX =>
                        $data
                ]
            )
        );
    }

    private function objectReflection(
        object $object
    ): ObjectReflection
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
            foreach (
                $data[JsonSerializedObject::DATA_INDEX]
                as
                $name => $originalValue
            ) {
                if(
                    is_string($originalValue)
                    &&
                    (false !== json_decode($originalValue))
                ) {
                    if(
                        str_contains(
                            $originalValue,
                            JsonSerializedObject::CLASS_INDEX
                        )
                        &&
                        str_contains(
                            $originalValue,
                            JsonSerializedObject::DATA_INDEX
                        )
                    ) {
                        $originalValue = decodeJsonToObject(
                            new JsonString($originalValue, true)
                        );
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
    new JsonSerializedObject(new JsonString(new Id())), // FAILS
    new JsonString(new JsonString(new Id())),
    new AlphanumericText(new Text('AlphanumericText')),
    new Id(),
    new Name(new Text('Name')),
    new SafeText(new Text('SafeText')),
    new Text('Text'),
    new UnknownClass(),
    new PrivateMethods(),
];

$testObject = $testObjects[array_rand($testObjects)];

$testJsonSerializedObject = new JsonSerializedObject($testObject);

$decodedTestObject = decodeJsonToObject($testJsonSerializedObject);
if($decodedTestObject::class === JsonSerializedObject::class) {
    /**
     * @var JsonSerializedObject $decodedTestObject
     *
     * This is a hack, really the __construct method should
     * be called when decoding. This will require first
     * instantiating a mock instance, then setting the
     * property values.
     *
     * @see Roady1.0::ReflectionUtilitiy::generateMockClassMethodArguments()
     * @see Roady1.0::ReflectionUtilitiy::getClassInstance()
     * @see https://github.com/sevidmusic/roady/blob/4307cdbb2d94b8017d5b6c825e75427d46274529/core/abstractions/utility/ReflectionUtility.php
     *
     * the decodeJsonToObject() method.
     */
    $decodedTestObject->__toString();
}

// save json for later viewing/debugging
file_put_contents(
    '/tmp/darlingTestJson.json',
    $testJsonSerializedObject->__toString()
);


$mocker = new Mocker(new ReflectionClass($decodedTestObject));
$mockInstance = $mocker->getClassInstance($decodedTestObject);
$mockInstanceMethods = $mocker->methodNames();
$methodName = $mockInstanceMethods[array_rand($mockInstanceMethods)];

dev_dump(
    'mock method argumetns for ' . $mockInstance::class . '::' . $methodName,
    $mocker->generateMockClassMethodArguments(
        $mockInstance,
        $methodName
    )
);
dev_dump(
    'mock instance',
    $mockInstance
);


dev_dump(
    '$decodedTestObject matches $testObject',
    $decodedTestObject == $testObject
);

dev_dump(
    '$mockInstance type === $testObject type',
    $mockInstance::class === $decodedTestObject::class
);

