<?php

/**
 * Purpose of this integration test:
 *
 * Test that arrays can be encoded as json via a Json instance, and
 * that a Json instance used to encode an array can be decoded back
 * to it's original value.
 */
include(
    str_replace(
        'tests' . DIRECTORY_SEPARATOR . 'integration',
        '',
        __DIR__
    ) .'vendor/autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPMockingUtilities\classes\mock\values\MockInt;

/**
 * Example of encoding an int:
 */
$int = new MockInt();

$jsonEncodedInt = new Json($int->value());

$jsonDecoder = new JsonDecoder();

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

if(
   $jsonDecoder->decode($jsonEncodedInt)  == $int->value()
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}

