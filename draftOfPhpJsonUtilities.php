<?php

include('/home/darling/Git/PHPJsonUtilities/vendor/autoload.php');

use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Darling\PHPTextTypes\classes\strings\UnknownClass;
use \Darling\PHPTextTypes\classes\strings\Id;

class JsonString extends Text
{

    public function __construct(private mixed $originalValue, private bool $originalValueIsJson = false) {
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
    return (object) $data;
}

$testObject = new Id();

$testJsonSerializedObject = new JsonSerializedObject($testObject);

$decodedTestObject = decodeJsonToObject($testJsonSerializedObject);

var_dump('$decodedTestObject matches $testObject', $decodedTestObject == $testObject);

// save json for later viewing/debugging
file_put_contents('/tmp/darlingTestJson.json', $testJsonSerializedObject->__toString());

