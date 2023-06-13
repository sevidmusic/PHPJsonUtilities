<?php

echo PHP_EOL  .
'This test is disabled until issue ' .
'#48 is resolved.' . PHP_EOL;

/**
 * This test is disabled until issue #48 is resolved
 * @see https://github.com/sevidmusic/PHPJsonUtilities/issues/48
 *
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

if(is_object($decodedObject) && ($decodedObject == $originalObject)) {
    echo PHP_EOL .
        'Test Passed: Classes that define readonly properties ' .
        'can be encoded as Json and decoded from Json.' . PHP_EOL;
    file_put_contents(
        '/tmp/darlingTestJson.json',
        PHP_EOL . $testJson
    );
} else {
    echo PHP_EOL . 'Test Failed' . PHP_EOL;
    die('The following integration test failed: ' . PHP_EOL . __FILE__);
}
 */
