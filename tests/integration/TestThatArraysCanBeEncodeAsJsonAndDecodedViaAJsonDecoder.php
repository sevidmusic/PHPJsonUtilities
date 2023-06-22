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

$array = [
    [
        'TestClassAInstance' => new TestClassA(new Id(), new Name(new Text('Name'))),
        'TestIteratorInstance' => new TestIterator(),
    ],
    new TestClassB(),
    new AlphanumericText(new Text('AlphanumericText')),
    'id' => new Id(),
    new Name(new Text('Name')),
    new SafeText(new Text('SafeText')),
    new Text('Text'),
    new UnknownClass(),
    new PrivateMethods(),
    [1, 2, 3],
    true,
    [false, null],
    [
        new UnknownClass(),
        new PrivateMethods(),
        [1, 2, 3],
        true,
        # function(): void {}, # fails
    ],
    # function(): void {}, # fails
];

$testJson = new Json($array);
$jsonDecoder = new JsonDecoder();
$decodedArray = $jsonDecoder->decode($testJson);

if($array == $decodedArray) {
    echo PHP_EOL . 'Test Passed: Arrays can be encoded as Json and decoded from Json.' . PHP_EOL;
    file_put_contents(
        '/tmp/darlingTestJson.json',
        PHP_EOL . $testJson
    );
} else {
    die('The following integration test failed: ' . PHP_EOL . __FILE__ . PHP_EOL);
}

