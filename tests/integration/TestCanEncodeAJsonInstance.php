<?php

/**
 * Purpose of this integration test:
 *
 * Test that Json instances can be encoded as json via a Json instance, and
 * that a Json instance used to encode an Json instance can be decoded back
 * to it's original value via a JsonDecoder.
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
use \Darling\PHPTextTypes\classes\strings\Id;

$jsonInstance = new Json(new Id());

$jsonEncodedJsonInstance = new Json($jsonInstance);

$expectedClassPrefix = str_replace(
    '\\',
    '',
    '{"__class__":"Darling\\PHPJsonUtilities\\classes\\encoded\\data\\Json"'
);

$actualClassPrefix = str_replace(
    '\\',
    '',
    substr($jsonEncodedJsonInstance->__toString(), 0, 70)
);

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

if(
    $expectedClassPrefix
    ===
    $actualClassPrefix
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}

