<?php

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
use \Darling\PHPTextTypes\classes\strings\ClassString;
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

if(is_object($decodedObject)) {
    echo 'Type of original object: ' . $originalObject::class . PHP_EOL;
    echo 'Type of decoded object: ' . $decodedObject::class . PHP_EOL;
    echo 'Decoded object matches original object:' . PHP_EOL;
    echo ($decodedObject == $originalObject ? 'true' : 'false') . PHP_EOL;
    file_put_contents(
        '/tmp/darlingTestJson.json',
        PHP_EOL . $testJson
    );
} else {
    echo 'Failed to decode the following json:' . PHP_EOL;
}

echo $testJson . PHP_EOL;

