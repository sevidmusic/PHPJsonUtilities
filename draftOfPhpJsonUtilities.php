<?php

include('/home/darling/Git/PHPJsonUtilities/vendor/autoload.php');

use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;
use \Darling\PHPTextTypes\classes\strings\Text;

class JsonString extends Text {

    public function __construct(private mixed $originalValue) {
        parent::__construct($this->encodeAsJson());
    }

    public function encodeAsJson() : string
    {
        return strval(json_encode($this->originalValue()));
    }

    public function __toString(): string
    {
        $json = $this->encodeAsJson();
        parent::__construct($json);
        return $json;
    }

    public function originalValue(): mixed {
        return $this->originalValue;
    }

}

class JsonSerializedObject extends JsonString {

    public const CLASS_INDEX = '__class__';
    public const DATA_INDEX = '__data__';

    public function __construct(
        private ObjectReflection $objectReflection
    ) {
        parent::__construct($this->originalObject());
    }

    public function originalObject(): object {
        return $this->objectReflection->reflectedObject();
    }

    public function encodeAsJson(): string {
        return strval(
            json_encode(
                [
                    self::CLASS_INDEX => $this->objectReflection->type()->__toString(),
                    self::DATA_INDEX => $this->objectReflection->propertyValues(),
                ]
            )
        );
    }

    public function __toString(): string {
        return $this->encodeAsJson();
    }

}

class JsonSerializedObjectDecoder
{

    public function decodeJsonToObject(JsonString $json): object {
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

}

$originalObject = new JsonString(
    ['Foo', 'Bar', 'Baz' => 'bazzer',]
);

$jsonSerializedObject = new JsonSerializedObject(
    new ObjectReflection($originalObject)
);
$originalObjectDecoder = new JsonSerializedObjectDecoder();

$unserializedObject = $originalObjectDecoder->decodeJsonToObject(
    $jsonSerializedObject
);

var_dump('Original Object', $originalObject);
var_dump('JsonSerializedObject', $jsonSerializedObject);
var_dump('Unserialized Object', $unserializedObject);
var_dump(
    'Objects are equal in terms of property values',
    $originalObject == $unserializedObject
);

var_dump(
    'Objects are of the same type',
    gettype($originalObject) === gettype($unserializedObject)
);

