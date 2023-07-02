<?php

/**
 * This file demonstrate how to use a Json instance to encode an
 * object instance as json.
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
 * Example of encoding an object:
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

