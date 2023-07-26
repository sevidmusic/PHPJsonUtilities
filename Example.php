<?php

include(__DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php');

use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json;

/**
 * This file demonstrates the basic usage of the Json
 * and JsonDecoder classes.
 */

class Foo {

    /**
     * Example class.
     *
     * @param int $int,
     * @param bool $bool,
     * @param string $string,
     * @param float $float,
     * @param array<mixed> $array,
     * @param Json $json
     *
     */
    public function __construct(
        private int $int,
        private bool $bool,
        protected string $string,
        public float $float,
        public array $array,
        public Json $json
    ) {}

    public function int():int {
        return $this->int;
    }
    public function bool(): bool {
        return $this->bool;
    }
    public function string(): string {
        return $this->string;
    }

}

$value = new Foo(
        rand(0, 100),
        boolval(rand(0, 1)),
        strval(json_encode(str_shuffle('abcdefg'))),
        floatval(strval(rand(1, 100)) . strval(rand(1, 100))),
        [
            rand(1, 100),
            [
                'string' => str_shuffle('abcdefg'),
            ],
        ],
        new Json(new Json(json_encode(str_shuffle('absdefg'))))
);

$json = new Json($value);

$jsonDecoder = new JsonDecoder();

/** @var Foo $decodedValue */
$decodedValue = $jsonDecoder->decode($json);

echo 'types match' . PHP_EOL;
echo ($value::class == $decodedValue::class ? 'true' : 'false') . PHP_EOL;

/**
 * == is used to compare $value with $decodedValue because we just
 * need verify object equality, i.e. equal type and property values,
 * not instance equality.
 */
echo 'object are equal in terms of type and property values.' . PHP_EOL;
echo ($value == $decodedValue ? 'true' : 'false') . PHP_EOL;

echo 'float property values match' . PHP_EOL;
echo ($value->float === $decodedValue->float ? 'true' : 'false') . PHP_EOL;

echo 'array property values match' . PHP_EOL;
echo ($value->array === $decodedValue->array ? 'true' : 'false') . PHP_EOL;

/**
 * When checking properties that accept an object instance,
 * == is used to compare original property value with the
 * decoded property value because we just need verify object
 * equality, i.e. equal type and property values, not instance
 * equality.
 */
echo 'json property values match in terms of object equality.' . PHP_EOL;
echo ($value->json == $decodedValue->json ? 'true' : 'false') . PHP_EOL;

echo 'int property values match' . PHP_EOL;
echo ($value->int() === $decodedValue->int() ? 'true' : 'false') . PHP_EOL;

echo 'bool property values match' . PHP_EOL;
echo ($value->bool() === $decodedValue->bool() ? 'true' : 'false') . PHP_EOL;

echo 'string property values match' . PHP_EOL;
echo ($value->string() === $decodedValue->string() ? 'true' : 'false') . PHP_EOL;

