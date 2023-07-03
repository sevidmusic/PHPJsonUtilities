<?php

/**
 * This file demonstrates how to use a Json instance to encode an
 * object instance that defines readonly properties as json.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAnObjectInstanceThatDefinesReadonlyProperties.php
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
$objectInstance = new DefinesReadonlyProperties(10);

$jsonEncodedObject = new Json($objectInstance);

echo $jsonEncodedObject . PHP_EOL;

/**
 * example output:
 *
 * {"__class__":"DefinesReadonlyProperties","__data__":{"int":10}}
 *
 */

