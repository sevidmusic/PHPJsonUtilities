<?php

/**
 * Purpose of this integration test:
 *
 * Test that bools can be encoded as json via a Json instance, and
 * that a Json instance used to encode an bool can be decoded back
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
use \Darling\PHPMockingUtilities\classes\mock\values\MockClosure;

$closure = new MockClosure();

$jsonEncodedClosure = new Json($closure->value());

$jsonDecoder = new JsonDecoder();

$decodedClosure = $jsonDecoder->decode($jsonEncodedClosure);

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

if(
    is_object($decodedClosure) && $decodedClosure::class == $closure->value()::class
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}

