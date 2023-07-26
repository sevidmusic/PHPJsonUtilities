<?php

/**
 * Purpose of this integration test:
 *
 * Test that instances of a class that defines readonly
 * propertiess can be encoded as json via a Json instance, and
 * that a Json instance used to encode an instance of a class
 * that defines readonly properties can be decoded back to it's
 * original value via a JsonDecoder.
 *
 */

include(
    str_replace(
        'tests' . DIRECTORY_SEPARATOR . 'integration',
        '',
        __DIR__
    ) .'vendor/autoload.php'
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

$originalObjectInstance = new DefinesReadonlyProperties(10);

$jsonEncodedObject = new Json($originalObjectInstance);

$jsonDecoder = new JsonDecoder();

$decodedObject = $jsonDecoder->decode($jsonEncodedObject);

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

if(
    is_object($decodedObject) && ($decodedObject::class == $originalObjectInstance::class)
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}

