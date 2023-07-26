<?php

/**
 * Purpose of this integration test:
 *
 * Test basic usage of the Json and JsonDecoder classes.
 *
 */

include(
    str_replace(
        'tests' . DIRECTORY_SEPARATOR . 'integration',
        '',
        __DIR__
    ) .'vendor/autoload.php'
);

use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json;

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
        str_shuffle('abcdefg'),
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

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

if(
    $value::class === $decodedValue::class
    &&
    $value == $decodedValue
    &&
    $value->float === $decodedValue->float
    &&
    $value->array === $decodedValue->array
    &&
    $value->json == $decodedValue->json
    &&
    $value->int() === $decodedValue->int()
    &&
    $value->bool() === $decodedValue->bool()
    &&
    $value->string() === $decodedValue->string()
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}
