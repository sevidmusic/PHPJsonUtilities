<?php

/**
 * This file demonstrates how to use a Json instance to encode an
 * object instance as json.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAnObjectInstance.php
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
 * Example of encoding an object:
 */
$objectInstance = new Id();

$jsonEncodedObject = new Json($objectInstance);

echo $jsonEncodedObject . PHP_EOL;

/**
 * example output:
 *
 * {"__class__":"Darling\\PHPTextTypes\\classes\\strings\\Id","__data__":{"text":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\AlphanumericText\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\Text\\\",\\\"__data__\\\":{\\\"string\\\":\\\"e7HyfqWD8p2NeU8TLXUJEtEjxIJlSx3HqgrrMhxIkYXyYLhSifrmGR7K3QGkrJ1lAo6Iuw40lwFj\\\"}}\",\"string\":\"E7HyfqWD8p2NeU8TLXUJEtEjxIJlSx3HqgrrMhxIkYXyYLhSifrmGR7K3QGkrJ1lAo6Iuw40lwFj\"}}","string":"E7HyfqWD8p2NeU8TLXUJEtEjxIJlSx3HqgrrMhxIkYXyYLhSifrmGR7K3QGkrJ1lAo6Iuw40lwFj"}}
 *
 */

// decoder
$jsonDecoder = new JsonDecoder();

