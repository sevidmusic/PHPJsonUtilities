<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a closure as json, and decode it via a JsonDecoder instance.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAClosure.php
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
use \Darling\PHPMockingUtilities\classes\mock\values\MockClosure;

/**
 * Example of encoding an closure:
 */
$closure = new MockClosure();

$jsonEncodedClosure = new Json($closure->value());

$jsonDecoder = new JsonDecoder();

echo 'original closure' . PHP_EOL;
var_dump($closure->value());

echo 'decoded closure' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedClosure));

