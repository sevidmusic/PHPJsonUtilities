<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * an array as json, and decode it via a JsonDecoder instance.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAnArray.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
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

echo 'original array' . PHP_EOL;
var_dump($array);

echo 'decoded array' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedArray));

