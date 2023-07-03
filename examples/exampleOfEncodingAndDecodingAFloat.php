<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a float as json.
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

echo $jsonEncodedFloat . PHP_EOL;

/**
 * example output:
 *
 * 2716017.3333333335
 *
 */

//decoder
$jsonDecoder = new JsonDecoder();

