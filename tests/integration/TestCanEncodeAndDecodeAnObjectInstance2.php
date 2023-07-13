<?php

/**
 * Purpose of this integration test:
 *
 * Test that objects can be encoded as json via a Json instance, and
 * that a Json instance can be decoded back to it's original value.
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
use \Darling\PHPTextTypes\classes\strings\AlphanumericText;
use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\Name;
use \Darling\PHPTextTypes\classes\strings\SafeText;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Darling\PHPTextTypes\classes\strings\UnknownClass;
use \Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\PrivateMethods;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassA;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassB;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestIterator;

$originalObjects = [
    new TestClassA(new Id(), new Name(new Text('Name'))),
    new TestIterator(),
    new TestClassB(),
    new AlphanumericText(new Text('AlphanumericText')),
    new Id(),
    new Name(new Text('Name')),
    new SafeText(new Text('SafeText')),
    new Text('Text'),
    new UnknownClass(),
    new PrivateMethods(),
];

$originalObject = $originalObjects[array_rand($originalObjects)];
$testJson = new Json($originalObject);
$jsonDecoder = new JsonDecoder();
$decodedObject = $jsonDecoder->decode($testJson);

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

if(
    is_object($decodedObject) && ($decodedObject == $originalObject)
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}

