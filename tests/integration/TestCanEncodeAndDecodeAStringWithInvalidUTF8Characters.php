<?php

/**
 * Purpose of this integration test:
 *
 * Test that strings that contain invalid utf8 characters can be
 * encoded as json via a Json instance, and that a Json instance
 * used to encode an strings that contain invalid utf8 character
 * can be decoded back to it's original value via a JsonDecoder.
 *
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

/**
 * Return a string composed of a random number of randomly
 * generated characters.
 *
 * Note: The string may contain invalid utf-8 characters.
 *
 * @return string
 *
 * @example
 *
 * ```
 * echo randomChars();
 * // example output: rqEzm*g1vRI7!lz#-%q
 *
 * echo randomChars();
 * // example output: @Lz%R+bgR#79l!mz-
 *
 * ```
 *
 */
function randomChars(): string
{
    $string = str_shuffle(
        'abcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_-=+'
    );
    try {
        $string .=
            random_bytes(random_int(1, 100)) .
            $string .
            random_bytes(random_int(1, 100));
    } catch(\Exception $e) {
    }
    return str_shuffle($string);
}

$string = randomChars();

$jsonEncodedString = new Json($string);

$expectedJsonString = json_encode(
    $string,
    JSON_INVALID_UTF8_SUBSTITUTE,
    2147483647
);

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

if(
    $jsonEncodedString->__toString() === $expectedJsonString
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m" . PHP_EOL . PHP_EOL;
} else {
    echo "\033[38;5;0m\033[48;5;196m Failed\033[48;5;0m" . PHP_EOL . PHP_EOL;
}
/** For debugging:

echo "\033[38;5;0m\033[48;5;45m Expected: \033[48;5;0m" . PHP_EOL . PHP_EOL;
var_dump($expectedJsonString);
echo "\033[38;5;0m\033[48;5;202m Actual: \033[48;5;0m" . PHP_EOL . PHP_EOL;
var_dump($jsonEncodedString->__toString());

 */
