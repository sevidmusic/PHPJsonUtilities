<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a valid json string as json, and decode it via a JsonDecoder
 * instance.
 *
 * Note:
 *
 * When a valid json string is encoded via a Json instance no
 * encoding actually occurs since the string is already valid
 * json.
 *
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAValidJsonString.php
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

/**
 * Example of encoding an validJsonString:
 */
$validJsonString = json_encode([1, 2, 3, 'foo' => ['bar', 'baz']]);

$jsonEncodedValidJsonString = new Json($validJsonString);

$jsonDecoder = new JsonDecoder();

echo 'original json string' . PHP_EOL;
var_dump($validJsonString);

echo 'decoded json string' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedValidJsonString));

/**
 * Note:
 *
 * A JsonDecoder will always decode valid json.
 *
 * If the encoded value was a valid json string then it will
 * be completely decoded by the JsonDecoder->decode() method.
 *
 * example output:
 *
 * original json string
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAValidJsonString.php:47:
 * string(39) "{"0":1,"1":2,"2":3,"foo":["bar","baz"]}"
 * decoded json string
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAValidJsonString.php:50:
 * array(4) {
 *   [0] =>
 *   int(1)
 *   [1] =>
 *   int(2)
 *   [2] =>
 *   int(3)
 *   'foo' =>
 *   array(2) {
 *     [0] =>
 *     string(3) "bar"
 *     [1] =>
 *     string(3) "baz"
 *   }
 * }
 *
 */
