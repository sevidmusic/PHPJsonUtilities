<?php

echo PHP_EOL  .
'This test is disabled until issue ' .
'#48 is resolved.' . PHP_EOL;

/**
 * This test is disabled until issue #48 is resolved
 * @see https://github.com/sevidmusic/PHPJsonUtilities/issues/48
 */
require(
    str_replace(
        'tests' . DIRECTORY_SEPARATOR . 'integration',
        'vendor',
        __DIR__,
    ) . DIRECTORY_SEPARATOR . 'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;

class ClassThatDefinesReadOnlyProperties
{
    public function __construct(
        public readonly int $readOnlyProperty
    ) {}
}

$originalObject = new ClassThatDefinesReadOnlyProperties(rand(0, 100));
$testJson = new Json($originalObject);
$jsonDecoder = new JsonDecoder();
$decodedObject = $jsonDecoder->decode($testJson);

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

if(
    is_object($decodedObject) && ($decodedObject::class == $originalObject::class)
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}

