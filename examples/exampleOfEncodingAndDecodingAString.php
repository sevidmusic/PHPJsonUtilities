<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a string as json, and decode it via a JsonDecoder instance.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAString.php
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
use \Darling\PHPMockingUtilities\classes\mock\values\MockString;

/**
 * Example of encoding a string:
 */
$string = new MockString();

$jsonEncodedString = new Json($string->value());

$jsonDecoder = new JsonDecoder();

echo 'original string';
var_dump($string->value());

echo 'decoded string';
var_dump($jsonDecoder->decode($jsonEncodedString));

