<?php

/**
 * Purpose of this integration test:
 *
 * Test that multi-dimensional arrays can be encoded as json via a
 * Json instance, and that a Json instance used to encode an multi-
 * dimensional array can be decoded back to it's original value via
 * a JsonDecoder.
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
use \Darling\PHPMockingUtilities\classes\mock\values\MockBool;
use \Darling\PHPMockingUtilities\classes\mock\values\MockFloat;
use \Darling\PHPMockingUtilities\classes\mock\values\MockInt;
use \Darling\PHPMockingUtilities\classes\mock\values\MockString;
use \Darling\PHPTextTypes\classes\strings\Id;
# use \Darling\PHPMockingUtilities\classes\mock\values\MockMixedValue; // fails randomly, probably because there are still decoding issues that have no been addressed

$bool = new MockBool();
$float = new MockFloat();
$int = new MockInt();
$string = new MockString();
#$mixed = new MockMixedValue(); // fails randomly, probably because there are still decoding issues that have no been addressed


$subArray = [
     $float->value(),
     $bool->value(),
     $int->value(),
     $string->value(),
     $int->value(),
     new Id(),
     [
         new Id(),
         new Id(),
         new Id(),
         new Id(),
         new Id(),
         new Id(),
         new Id(),
     ],
     # $mixed->value(), // fails randomly, probably because there are still decoding issues that have no been addressed
];

$array = [
    $float->value(),
    [
        $subArray,
        [$subArray],
    ],
    $bool->value(),
    [
        $int->value(),
        $string->value(),
    ],
    $int->value(),
    $subArray,
    [],
    [
        [
            'foo' => 'bar',
            'bin' => 'baz',
        ],
        null,
        0,
    ]
];

$jsonEncodedArray = new Json($array);

$jsonDecoder = new JsonDecoder();

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

/**
 * Note:
 * == is used instead of === to allow for object equality since
 * decoded object in the array will not be same instance but
 * should have same property values.
 */
if(
    $jsonDecoder->decode($jsonEncodedArray) == $array
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}

