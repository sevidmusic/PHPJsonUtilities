<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * an array as json, and decode it via a JsonDecoder instance.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAnArray.php
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

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPMockingUtilities\classes\mock\values\MockBool;
use \Darling\PHPMockingUtilities\classes\mock\values\MockClosure;
use \Darling\PHPMockingUtilities\classes\mock\values\MockFloat;
use \Darling\PHPMockingUtilities\classes\mock\values\MockInt;
use \Darling\PHPMockingUtilities\classes\mock\values\MockMixedValue;
use \Darling\PHPMockingUtilities\classes\mock\values\MockString;
use \Darling\PHPTextTypes\classes\strings\Id;

$bool = new MockBool();
$closure = new MockClosure();
$float = new MockFloat();
$int = new MockInt();
$mixed = new MockMixedValue();
$string = new MockString();

/**
 * Example of encoding an array as json via a Json instance. and
 * decoding it via a JsonDecoder instance.
 *
 * Note: Nested objects and arrays will also be properly encoded.
 *
 */
$array = [
    $bool->value(),
    $closure->value(),
    $float->value(),
    $int->value(),
    $mixed->value(),
    $string->value(),
    'nested-array' => [
        [
            new Id(),
            new Id(),
            new Id(),
        ]
    ]
];
$jsonEncodedArray = new Json($array);

$jsonDecoder = new JsonDecoder();

echo 'original array' . PHP_EOL;
var_dump($array);

echo 'decoded array' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedArray));

/**
 * example output:
 *
 * ```
 * original array
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAnArray.php:70:
 * array(7) {
 *   [0] =>
 *   bool(false)
 *   [1] =>
 *   class Closure#8 (1) {
 *       virtual $closure =>
 *       "$this->Darling\PHPMockingUtilities\classes\mock\values\{closure}"
 *     public $this =>
 *     class Darling\PHPMockingUtilities\classes\mock\values\MockClosure#2 (0) {
 *     }
 *   }
 *   [2] =>
 *   double(665387.83333333)
 *   [3] =>
 *   int(3797309511412571283)
 *   [4] =>
 *   string(62) "q3vIwEMKpostgOCBFePmfdr6hyUXGN91AWaD8Qzj2VHZc5bTYiklL0uJx7nSR4"
 *   [5] =>
 *   string(49) "MockStringYkW2R9URVtUiTrlSNodhLmLSCBP3E5fD7fcyGDd"
 *   'nested-array' =>
 *   array(1) {
 *     [0] =>
 *     array(3) {
 *       [0] =>
 *       class Darling\PHPTextTypes\classes\strings\Id#7 (2) {
 *         ...
 *       }
 *       [1] =>
 *       class Darling\PHPTextTypes\classes\strings\Id#12 (2) {
 *         ...
 *       }
 *       [2] =>
 *       class Darling\PHPTextTypes\classes\strings\Id#15 (2) {
 *         ...
 *       }
 *     }
 *   }
 * }
 * decoded array
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAnArray.php:73:
 * array(7) {
 *   [0] =>
 *   bool(false)
 *   [1] =>
 *   class Closure#25 (1) {
 *       virtual $closure =>
 *       "$this->Darling\PHPMockingUtilities\classes\mock\values\{closure}"
 *     public $this =>
 *     class Darling\PHPMockingUtilities\classes\mock\values\MockClosure#21 (0) {
 *     }
 *   }
 *   [2] =>
 *   double(665387.83333333)
 *   [3] =>
 *   int(3797309511412571283)
 *   [4] =>
 *   string(62) "q3vIwEMKpostgOCBFePmfdr6hyUXGN91AWaD8Qzj2VHZc5bTYiklL0uJx7nSR4"
 *   [5] =>
 *   string(49) "MockStringYkW2R9URVtUiTrlSNodhLmLSCBP3E5fD7fcyGDd"
 *   'nested-array' =>
 *   array(1) {
 *     [0] =>
 *     array(3) {
 *       [0] =>
 *       class Darling\PHPTextTypes\classes\strings\Id#29 (2) {
 *         ...
 *       }
 *       [1] =>
 *       class Darling\PHPTextTypes\classes\strings\Id#43 (2) {
 *         ...
 *       }
 *       [2] =>
 *       class Darling\PHPTextTypes\classes\strings\Id#46 (2) {
 *         ...
 *       }
 *     }
 *   }
 * }
 *
 * ```
 *
 */
