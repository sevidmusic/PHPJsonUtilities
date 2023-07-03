<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a float as json, and decode it via a JsonDecoder instance.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAFloat.php
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
use \Darling\PHPMockingUtilities\classes\mock\values\MockFloat;

/**
 * Example of encoding an float:
 */
$float = new MockFloat();

$jsonEncodedFloat = new Json($float->value());

$jsonDecoder = new JsonDecoder();

echo 'original float' . PHP_EOL;
var_dump($float->value());

echo 'decoded float' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedFloat));

/**
 * example output:
 *
 * ```
 * original float
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAFloat.php:40:
 * double(1512273.8)
 * decoded float
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAFloat.php:43:
 * double(1512273.8)
 *
 * ```
 *
 */
