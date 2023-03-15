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
        $objectReflection = $this->objectReflection($object);
        // refactor to be recursive: i.e., foreach($objectReflection->propertyValues() ...) {...}
        return strval(
            json_encode(
                [
                    self::CLASS_INDEX => $objectReflection->type()->__toString(),
                    self::DATA_INDEX => $objectReflection->propertyValues(),
                ]
            )
        );
    }

    private function objectReflection(object $object): ObjectReflection
    {
        return new ObjectReflection($object);
    }

}

$closure = function (): float {
    return floatval(
        strval(rand(0, 100,)) . '.' . strval(rand(0, 1000))
    );
};

$array = [1, 2, 3, [4, 5, 6], ['7', '8', [9, 10, 11]], 'Tz', '=', 'Tzo'];

$testValues = [
    'string' => 'Foo bar baz.',
    'array' => $array,
    'bool' => boolval(rand(0, 1)),
    'int' => rand(0, 100),
    'closure' => $closure,
    'float' => $closure(),
    'object' => new Id(),
    'standardObject' => new stdClass(),
    'castObject' => (object) $array,
];

$testValue = $testValues[array_rand($testValues)];

var_dump(
    'test value type',
    (
        is_object($testValue)
        ? $testValue::class
        : gettype($testValue)
    )
);

$testJsonString = new JsonString($testValue);

var_dump('JsonString', $testJsonString->__toString());

$testJsonSerializedObject = new JsonSerializedObject(
    $testJsonString
);

var_dump('JsonSerializedObject(JsonString)', $testJsonSerializedObject->__toString());

