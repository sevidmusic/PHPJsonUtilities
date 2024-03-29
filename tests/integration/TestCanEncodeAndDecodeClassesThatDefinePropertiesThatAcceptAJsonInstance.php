<?php

/**
 * Purpose of this integration test:
 *
 * Test that instances of classes that define properties that accept
 * a json instance can be encoded as json via a Json instance, and
 * that a Json instance used to encode an instance of classes that
 * define properties that accept a json instance can be decoded back
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
use \Darling\PHPMockingUtilities\classes\mock\values\MockClassInstance;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPTextTypes\classes\strings\ClassString;
use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\Name;

class Bar {

    /** @var array<Id> */
    private array $ids;

    public function __construct(
        private Json $json,
        Id ...$ids
    ) {
        foreach($ids as $id) {
            $this->ids[] = $id;
        }
    }

    public function json(): Json
    {
        return $this->json;
    }

    /** @return array<Id> */
    public function ids(): array
    {
        return $this->ids;
    }

}

$mn = new MockClassInstance(
    new Reflection(
        new ClassString(
            Name::class
        )
    )
);

$mi = new MockClassInstance(
    new Reflection(
        new ClassString(
            Id::class
        )
    )
);

/** @var Id $id1 */
$id1 = $mi->mockInstance();
/** @var Id $id2 */
$id2 = $mi->mockInstance();
/** @var Id $id3 */
$id3 = $mi->mockInstance();
/** @var Id $id4 */
$id4 = $mi->mockInstance();

$bar = new Bar(new Json($mn->mockInstance()), $id1, $id2, $id3, $id4);
$barJson = new Json($bar);
$jsonDecoder = new JsonDecoder();

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

if(
    $jsonDecoder->decode($barJson) == $bar
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}

