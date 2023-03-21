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

var_dump($testObject::class, $decodedTestObject::class);
var_dump('$decodedTestObject matches $testObject', $decodedTestObject == $testObject);
#var_dump('$testObject', $testObject);
#var_dump('$decodedTestObject', $decodedTestObject);

// save json for later viewing/debugging
file_put_contents('/tmp/darlingTestJson.json', $testJsonSerializedObject->__toString());

