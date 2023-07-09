<?php

include(
    str_replace(
        'tests' . DIRECTORY_SEPARATOR . 'integration',
        '',
        __DIR__
    ) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassThatDefinesAPropertyThatAcceptsAnArrayOfObjects;

$classDefinePropertyThatAcceptsAnArrayOfObjects =
    new TestClassThatDefinesAPropertyThatAcceptsAnArrayOfObjects(
        new stdClass(),
        new TestClassThatDefinesAPropertyThatAcceptsAnArrayOfObjects(new stdClass()),
        new Id(),

    );

$json = new Json($classDefinePropertyThatAcceptsAnArrayOfObjects);
$jsonDecoder = new JsonDecoder();

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

if(
    $classDefinePropertyThatAcceptsAnArrayOfObjects
    ==
    $jsonDecoder->decode($json)
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}

