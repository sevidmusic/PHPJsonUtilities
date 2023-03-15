<?php

include('/home/darling/Git/PHPJsonUtilities/vendor/autoload.php');

use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Darling\PHPTextTypes\classes\strings\Id;

class JsonString extends Text
{

    public function __construct(private mixed $originalValue) {
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

    final protected function encodeOriginalValueAsJson() : void
    {
        parent::__construct($this->jsonEncode());
    }

    protected function jsonEncode(): string
    {
        return strval(json_encode($this->originalValue()));
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
        // refactor to be recursive: i.e., foreach($objectReflection->propertyValues() ...) {...}
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

$testObject = new Id();

$jsonString = new JsonString($testObject);

$testJsonSerializedObject = new JsonSerializedObject($testObject);

var_dump('JsonString', $jsonString->__toString());
var_dump('JsonSerializedObject(JsonString)', $testJsonSerializedObject->__toString());
var_dump('decoded via json_decode($value, true)', json_decode($testJsonSerializedObject));


