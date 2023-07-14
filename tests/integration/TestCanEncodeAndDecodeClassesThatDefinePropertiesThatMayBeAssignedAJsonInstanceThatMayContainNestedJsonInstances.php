<?php

/**
 * Purpose of this integration test:
 *
 * Test that instances of classes that define properties that accept
 * a json instance which encodes other Json instances can be encoded
 * as json via a Json instance, and that a Json instance used to
 * encode an instance of classe that define properties that accept
 * a json instance which encodes other Json instances can be decoded
 * back to it's original value via a JsonDecoder.
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

$jsonDecoder = new JsonDecoder();
/** @var Id $id1 */
$id1 = $mi->mockInstance();
/** @var Id $id2 */
$id2 = $mi->mockInstance();
/** @var Id $id3 */
$id3 = $mi->mockInstance();
/** @var Id $id4 */
$id4 = $mi->mockInstance();
$bar = new Bar(new Json($mn->mockInstance()), $id1, $id2, $id3, $id4);
$fails = 0;
$passes = 0;

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

/**
 * WARNING: This test will continue to create new instances of Bar,
 * passing a Json instance that encoded the previous Bar instance
 * to the new Bar's __construct() method.
 *
 * This means each new Bar will contain a Json instance that encodes
 * other Bars. This will lead to a great deal of nesting, and puts a
 * lot of stress on the JsonDecoder->decode() method when it is called
 * to decode the last Json encoded Bar instance.
 *
 * WARNING: This test fails if $i is >= 12.
 * This needs further investigation.
 *
 * @see https://github.com/sevidmusic/PHPJsonUtilities/issues/65
 *
 */
for($i = 0; $i < rand(1, 11); $i++) {
    $barJson = new Json($bar);
    if(
        $jsonDecoder->decode($barJson) == $bar
    ) {
        $passes++;
    } else {
        $fails++;
    }
    $bar = new Bar($barJson, $id1, $id2, $id3, $id4);
}
if($fails === 0) {
    echo "\033[38;5;0m\033[48;5;84mPasses: " . $passes . " \033[48;5;0m" . PHP_EOL;
} else {
    echo "\033[38;5;0m\033[48;5;196mFails: " . $fails . " \033[48;5;0m" . PHP_EOL;
}

