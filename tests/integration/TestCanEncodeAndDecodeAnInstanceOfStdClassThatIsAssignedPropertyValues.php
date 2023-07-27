<?php

/**
 * Purpose of this integration test:
 *
 * Test that instance of stdClass that is assigned property
 * values can be encoded as json via a Json instance, and that
 * a Json instance used to encode an instance of stdClass that
 * is assigned property value can be decoded back to it's
 * original value via a JsonDecoder.
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

$stdClass = new stdClass();
$stdClass->string = str_shuffle('abcdefg');
$stdClass->string = floatval(strval(rand(1, 100)) . strval(rand(1, 100)));
$stdClass->json = new Json(str_shuffle('abcdefg'));

$jsonEncodedStdClass = new Json($stdClass);

$jsonDecoder = new JsonDecoder();

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

if(
    $jsonDecoder->decode($jsonEncodedStdClass) == $stdClass
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}

