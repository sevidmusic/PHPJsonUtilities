<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a Json instance as json, and decode it via a JsonDecoder instance.
 *
 * Note:
 *
 * When a Json instance is used to encode another Json instance no
 * encoding actually occurs, instead the Json instance performing
 * the encoding becomes a clone of the Json instance being encoded.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAJsonInstance.php
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
use \Darling\PHPTextTypes\classes\strings\Id;


/**
 * Example of encoding an jsonInstance:
 */
$jsonInstance = new Json(new Id());

$jsonEncodedJsonInstance = new Json($jsonInstance);

$jsonDecoder = new JsonDecoder();

echo 'original json string' . PHP_EOL;
var_dump($jsonInstance);

echo 'decoded json string' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedJsonInstance));

