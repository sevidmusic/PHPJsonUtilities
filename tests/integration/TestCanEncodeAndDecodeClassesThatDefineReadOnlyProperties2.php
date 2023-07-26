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

require(
    str_replace(
        'tests' . DIRECTORY_SEPARATOR . 'integration',
        'vendor',
        __DIR__,
    ) . DIRECTORY_SEPARATOR . 'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassDefinesReadOnlyProperties;

$originalObject = new TestClassDefinesReadOnlyProperties(
    TestClassDefinesReadOnlyProperties::class
);
$testJson = new Json($originalObject);
$jsonDecoder = new JsonDecoder();
$decodedObject = $jsonDecoder->decode($testJson);

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

if(
    is_object($decodedObject) && ($decodedObject::class == $originalObject::class)
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}

