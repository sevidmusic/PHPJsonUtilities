<?php

/**
 * This file demonstrates how to use a Json instance to encode an
 * object instance as json, and then decode it via a JsonDecoder.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAndDecodingAnObjectInstance.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPTextTypes\classes\strings\Id;

/**
 * Example of encoding an object:
 */
$originalObjectInstance = new Id();

$jsonEncodedObject = new Json($originalObjectInstance);

$jsonDecoder = new JsonDecoder();

echo 'original object' . PHP_EOL;
var_dump($originalObjectInstance);
echo 'decoded object' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedObject));

/**
 * Example output:
 * original object
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAnObjectInstance.php:40:
 * class Darling\PHPTextTypes\classes\strings\Id#3 (2) {
 *   private string $string =>
 *   string(63) "BE7rwPudk3awquVe0KjImsyyOhRHS9FloSLPtC8Ud0LG6BRn2VKI6Yaz8BE3JZg"
 *   private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *   class Darling\PHPTextTypes\classes\strings\AlphanumericText#2 (2) {
 *     private string $string =>
 *     string(63) "BE7rwPudk3awquVe0KjImsyyOhRHS9FloSLPtC8Ud0LG6BRn2VKI6Yaz8BE3JZg"
 *     private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *     class Darling\PHPTextTypes\classes\strings\Text#4 (1) {
 *       private string $string =>
 *       string(63) "bE7rwPudk3awquVe0KjImsyyOhRHS9FloSLPtC8Ud0LG6BRn2VKI6Yaz8BE3JZg"
 *     }
 *   }
 * }
 * decoded object
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAnObjectInstance.php:42:
 * class Darling\PHPTextTypes\classes\strings\Id#12 (2) {
 *   private string $string =>
 *   string(63) "BE7rwPudk3awquVe0KjImsyyOhRHS9FloSLPtC8Ud0LG6BRn2VKI6Yaz8BE3JZg"
 *   private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *   class Darling\PHPTextTypes\classes\strings\AlphanumericText#20 (2) {
 *     private string $string =>
 *     string(63) "BE7rwPudk3awquVe0KjImsyyOhRHS9FloSLPtC8Ud0LG6BRn2VKI6Yaz8BE3JZg"
 *     private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *     class Darling\PHPTextTypes\classes\strings\Text#15 (1) {
 *       private string $string =>
 *       string(63) "bE7rwPudk3awquVe0KjImsyyOhRHS9FloSLPtC8Ud0LG6BRn2VKI6Yaz8BE3JZg"
 *     }
 *   }
 * }
 *
 */
