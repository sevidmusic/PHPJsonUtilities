<?php

/**
 * Purpose of this integration test:
 *
 * Test that associatively indexed arrays can be encoded as json via
 * a Json instance, and that a Json instance used to encode an
 * associatively indexed array can be decoded back to it's original
 * value via a JsonDecoder.
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
use \Darling\PHPMockingUtilities\classes\mock\values\MockBool;
use \Darling\PHPMockingUtilities\classes\mock\values\MockFloat;
use \Darling\PHPMockingUtilities\classes\mock\values\MockInt;
use \Darling\PHPMockingUtilities\classes\mock\values\MockString;
use \Darling\PHPTextTypes\classes\strings\Id;

$bool = new MockBool();
$float = new MockFloat();
$int = new MockInt();
$string = new MockString();

$array = [
    'float' => $float->value(),
    'bool' => $bool->value(),
    'int' => $int->value(),
    'Id' => new Id(),
];
$jsonEncodedArray = new Json($array);

$jsonDecoder = new JsonDecoder();

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

/**
 * Note:
 * == is used instead of === to allow for object equality since
 * decoded objects in the array will not be same instance but
 * should have same property values.
 */
if(
    $jsonDecoder->decode($jsonEncodedArray) == $array
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}

