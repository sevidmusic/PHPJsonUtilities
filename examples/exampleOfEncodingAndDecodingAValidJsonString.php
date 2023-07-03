<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a valid json string.
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

echo $validJsonString . PHP_EOL;
echo $jsonEncodedValidJsonString . PHP_EOL;

/**
 * example output:
 *
 * {"0":1,"1":2,"2":3,"foo":["bar","baz"]}
 * {"0":1,"1":2,"2":3,"foo":["bar","baz"]}
 *
 */

//decoder
$jsonDecoder = new JsonDecoder();

