<?php

/**
 * Purpose of this integration test:
 *
 * Test that valid json strings can be encoded as json via a Json
 * instance and decoded to their original value via a JsonDecoder
 * instance.
 *
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

$validJsonString = json_encode([1, 2, 3, 'foo' => ['bar', 'baz']]);

$jsonEncodedValidJsonString = new Json($validJsonString);

$jsonDecoder = new JsonDecoder();

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

if(
   $jsonDecoder->decode($jsonEncodedValidJsonString) === $validJsonString
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}

