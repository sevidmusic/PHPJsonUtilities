<?php

/**
 * Purpose of this integration test:
 *
 * Test that instances of classes that define properties that
 * accept an array that may contain objects can be encoded as
 * json via a Json instance, and that a Json instance used to
 * encode an instance of a class that defines properties that
 * accept an array that may contain objects can be decoded back
 * to it's original value via a JsonDecoder.
 *
 */

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

use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassThatDefinesAPropertyThatAcceptsAnArrayOfObjects;
use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\Name;
use \Darling\PHPTextTypes\classes\strings\Text;

$classDefinesAPropertyThatAcceptsAnArrayOfObjects =
    new TestClassThatDefinesAPropertyThatAcceptsAnArrayOfObjects(
        new stdClass(),
        new TestClassThatDefinesAPropertyThatAcceptsAnArrayOfObjects(new stdClass()),
        new Id(),
        new Name(new Text('Foo bar baz')),

    );

$jsonEncodedClassThatDefinesAPropertyThatAcceptsAnArrayOfObjects =
    new Json($classDefinesAPropertyThatAcceptsAnArrayOfObjects);

$jsonDecoder = new JsonDecoder();

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

if(
    $jsonDecoder->decode(
        $jsonEncodedClassThatDefinesAPropertyThatAcceptsAnArrayOfObjects
    )
    ==
    $classDefinesAPropertyThatAcceptsAnArrayOfObjects
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}

