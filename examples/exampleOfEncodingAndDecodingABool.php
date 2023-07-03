<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a bool as json, and decode it via a JsonDecoder instance.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingABool.php
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

/**
 * Example of encoding an bool:
 */
$bool = new MockBool();

$jsonEncodedBool = new Json($bool->value());

$jsonDecoder = new JsonDecoder();

echo 'original bool' . PHP_EOL;
var_dump($bool->value());

echo 'decoded bool' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedBool));

