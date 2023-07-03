<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * an int as json, and decode it via a JsonDecoder instance.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAnInt.php
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
use \Darling\PHPMockingUtilities\classes\mock\values\MockInt;

/**
 * Example of encoding an int:
 */
$int = new MockInt();

$jsonEncodedInt = new Json($int->value());

$jsonDecoder = new JsonDecoder();

echo 'original int' . PHP_EOL;
var_dump($int->value());

echo 'decoded int' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedInt));

/**
 * example output:
 *
 * ```
 * original int
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAnInt.php:40:
 * int(2093209321154253834)
 * decoded int
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAnInt.php:43:
 * int(2093209321154253834)
 *
 * ```
 *
 */
