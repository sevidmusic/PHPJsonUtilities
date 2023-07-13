<?php

/**
 * Purpose of this integration test:
 *
 * Test that Class's that define readonly properties can be encoded
 * as json via a Json instance, and that a Json instance used to
 * encode a Class that define readonly properties can be decoded
 * back to it's original value.
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


echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

if(
    $jsonDecoder->decode($jsonEncodedObject) == $originalObjectInstance
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}

