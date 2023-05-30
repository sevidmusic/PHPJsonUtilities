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

if(is_object($decodedObject) && ($decodedObject == $originalObject)) {
    echo PHP_EOL . 'Test Passed: Objects can be encoded as Json and decoded from Json.' . PHP_EOL;
    file_put_contents(
        '/tmp/darlingTestJson.json',
        PHP_EOL . $testJson
    );
} else {
    echo PHP_EOL . 'Test Failed' . PHP_EOL;
    die('The following integration test failed: ' . PHP_EOL . __DIR__ . DIRECTORY_SEPARATOR . __FILE__);
}


