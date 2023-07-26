<?php

/**
 * Purpose of this integration test:
 *
 * Test that instances of a TestClassCoversMultipleEdgeCasess can be
 * encoded as json via a Json instance, and that a Json instance
 * used to encode an instance of a TestClassCoversMultipleEdgeCases
 * can be decoded back to it's original value via a JsonDecoder.
 */

include(
    str_replace(
        'tests' . DIRECTORY_SEPARATOR . 'integration',
        '',
        __DIR__
    ) .'vendor/autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassCoversMultipleEdgeCases;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestIterator;
use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;
use \Darling\PHPTextTypes\classes\strings\Id;

$orignalInstance = new TestClassCoversMultipleEdgeCases(
    strval(json_encode(str_shuffle('abcdefg'))),
    new ObjectReflection(new Id()),
    new Json(json_encode([str_shuffle('abcdefg') => str_shuffle('abcdefg')])),
    new Id(),
    function() : void {},
    # new TestIterator, # currently fails because a MockClassInstance cannot mock a class that expects an implementation of PHP's Iterator interface | re-enable once this issue is resolved
    [
        new Id(),
        new Id(),
        str_shuffle('abcdefg'),
        str_shuffle('abcdefg') => str_shuffle('abcdefg'),
        [str_shuffle('abcdefg') => str_shuffle('abcdefg')],
        [
            Id::class,
            new Id(),
            str_shuffle('abcdefg'),
            str_shuffle('abcdefg') => str_shuffle('abcdefg'),
            [
                str_shuffle('abcdefg')
                =>
                str_shuffle('abcdefg')
            ],
            new Json(
                json_encode(
                    [
                        str_shuffle('abcdefg')
                        =>
                        str_shuffle('abcdefg')
                    ]
                )
            ),
        ],
    ],
);

$jsonEncodedTestClassCoversMultipleEdgeCases = new Json(
    $orignalInstance
);

$jsonDecoder = new JsonDecoder();

$decodedInstance = $jsonDecoder->decode(
    $jsonEncodedTestClassCoversMultipleEdgeCases
);

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

if(
    is_object($decodedInstance)
    &&
    $decodedInstance::class
    ===
    $orignalInstance::class
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}

