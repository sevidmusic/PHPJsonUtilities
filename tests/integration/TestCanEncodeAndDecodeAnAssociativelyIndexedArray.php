<?php


/**
 * Purpose of this integration test:
 *
 * Test that bools can be encoded as json via a Json instance, and
 * that a Json instance used to encode an bool can be decoded back
 * to it's original value.
 */
include(
    str_replace(
        'tests' . DIRECTORY_SEPARATOR . 'integration',
        '',
        __DIR__
    ) .'vendor/autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPMockingUtilities\classes\mock\values\MockBool;
use \Darling\PHPMockingUtilities\classes\mock\values\MockClosure;
use \Darling\PHPMockingUtilities\classes\mock\values\MockFloat;
use \Darling\PHPMockingUtilities\classes\mock\values\MockInt;
use \Darling\PHPMockingUtilities\classes\mock\values\MockMixedValue;
use \Darling\PHPMockingUtilities\classes\mock\values\MockString;
use \Darling\PHPTextTypes\classes\strings\Id;

$bool = new MockBool();
$closure = new MockClosure();
$float = new MockFloat();
$int = new MockInt();
$mixed = new MockMixedValue();
$string = new MockString();

/**
 * Example of encoding an array as json via a Json instance. and
 * decoding it via a JsonDecoder instance.
 *
 * Note: Nested objects and arrays will also be properly encoded.
 *
 */
$array = [
    $bool->value(),
    $closure->value(),
    $float->value(),
    $int->value(),
    $mixed->value(),
    $string->value(),
    'nested-array' => [
        [
            new Id(),
            new Id(),
            new Id(),
        ]
    ]
];
$jsonEncodedArray = new Json($array);

$jsonDecoder = new JsonDecoder();

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

if(
    $jsonDecoder->decode($jsonEncodedArray) == $array
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}

