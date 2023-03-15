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
        // Always call encodeOriginalValueAsJson() before calling
        // parent::__toString() in case original value has changed.
        $this->encodeOriginalValueAsJson();
        return parent::__toString();
    }

    public function originalValue(): mixed {
        return $this->originalValue;
    }

    final protected function encodeOriginalValueAsJson() : void
    {
        parent::__construct(
            $this->jsonEncode()
        );
    }

    protected function jsonEncode(): string
    {
        return strval(json_encode($this->originalValue()));
    }

}

class JsonSerializedObject extends JsonString
{

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

    protected function jsonEncode(): string {
        $data = [];
        foreach($this->objectReflection->propertyValues() as $name => $value)
        {
            $data[$name] = match(is_object($value)) {
               true => serialize($value),
                default => $value,
            };
        }
        return strval(json_encode($data));
    }

}

$closure = function (): float {
    return floatval(
        strval(rand(0, 100,)) . '.' . strval(rand(0, 1000))
    );
};

$array = [1, 2, 3, [4, 5, 6], ['7', '8', [9, 10, 11]]];

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
    new ObjectReflection($testJsonString)
);

var_dump('JsonSerializedObject(JsonString)', $testJsonSerializedObject->__toString());

