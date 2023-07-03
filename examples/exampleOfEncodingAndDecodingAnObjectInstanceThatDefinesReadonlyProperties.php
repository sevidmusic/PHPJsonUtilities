<?php

/**
 * This file demonstrates how to use a Json instance to encode an
 * object instance that defines readonly properties as json, and
 * then decode it via a JsonDecoder.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAndDecodingAnObjectInstanceThatDefinesReadonlyProperties.php
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

use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json;

class DefinesReadonlyProperties
{

    public function __construct(private readonly int $int) {}

    public function getInt(): int
    {
        return $this->int;
    }
}

/**
 * Example of encoding an object that defines readonly properties:
 */
$originalObjectInstance = new DefinesReadonlyProperties(10);

$jsonEncodedObject = new Json($originalObjectInstance);

$jsonDecoder = new JsonDecoder();

echo 'original object' . PHP_EOL;
var_dump($originalObjectInstance);
echo 'decoded object' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedObject));

/**
 * Notice that properties that are defined as readonly are decoded to
 * the correct type, but may not be decoded to their original value.
 * This only applies to readonly properties.
 *
 * example output:
 * original object
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAnObjectInstanceThatDefinesReadonlyProperties.php:50:
 * class DefinesReadonlyProperties#3 (1) {
 *   private readonly int $int =>
 *   int(10)
 * }
 * decoded object
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAnObjectInstanceThatDefinesReadonlyProperties.php:52:
 * class DefinesReadonlyProperties#10 (1) {
 *   private readonly int $int =>
 *   int(7403326686579584685)
 * }
 */

