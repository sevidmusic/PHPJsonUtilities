<?php

require_once(
    __DIR__ .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\Text;

$jsonDecoder = new JsonDecoder();

$objectInstance = new Id();

$jsonEncodedObject = new Json($objectInstance);

$decodedObject = $jsonDecoder->decode($jsonEncodedObject);

var_dump($decodedObject);

/**
 * example output:
 * class Darling\PHPTextTypes\classes\strings\Id#9 (2) {
 *   private string $string =>
 *   string(74) "Zz7SsSjwk1XAyOwIfaJpJkQ7tCWmRxBEql5P8WXFB1rKE9TqWYvgs6A5VbnZ8GioHNFAwhvjKd"
 *   private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *   class Darling\PHPTextTypes\classes\strings\AlphanumericText#17 (2) {
 *     private string $string =>
 *     string(74) "Zz7SsSjwk1XAyOwIfaJpJkQ7tCWmRxBEql5P8WXFB1rKE9TqWYvgs6A5VbnZ8GioHNFAwhvjKd"
 *     private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *     class Darling\PHPTextTypes\classes\strings\Text#18 (1) {
 *       private string $string =>
 *       string(74) "zz7SsSjwk1XAyOwIfaJpJkQ7tCWmRxBEql5P8WXFB1rKE9TqWYvgs6A5VbnZ8GioHNFAwhvjKd"
 *     }
 *   }
 * }
 */

$array = [
    1,
    1.2,
    true,
    false,
    null,
    'string',
    [],
    new Text(str_shuffle('abcdefg')),
    'sub_array' => [
        'secondary_id' => new Id(),
        'sub_sub_array' => [new Id(), [1, 2, 3, [new Id()]], 1.2, []],
    ],
    'foo' => 'bar',
    'id' => new Id(),
    'closure' => function(): void {},
    'second_sub_array' => [
        [[['id' => new Id()], [function(): void {}]], new stdClass()],
    ],
];

$jsonEncodedArray = new Json($array);

$decodedArray = $jsonDecoder->decode($jsonEncodedArray);

var_dump($decodedArray);

/**
 * example output:
 * array(13) {
 *   [0] =>
 *   int(1)
 *   [1] =>
 *   double(1.2)
 *   [2] =>
 *   bool(true)
 *   [3] =>
 *   bool(false)
 *   [4] =>
 *   NULL
 *   [5] =>
 *   string(6) "string"
 *   [6] =>
 *   array(0) {
 *   }
 *   [7] =>
 *   class Darling\PHPTextTypes\classes\strings\Text#31 (1) {
 *     private string $string =>
 *     string(7) "efdgcab"
 *   }
 *   'sub_array' =>
 *   array(2) {
 *     'secondary_id' =>
 *     class Darling\PHPTextTypes\classes\strings\Id#23 (2) {
 *       private string $string =>
 *       string(64) "CoSksBkY7Gc5sAwAliSnqoLIBUnPdMFjmOap7fzJbfh6mbhD6Z8erjEYLrsQ3PNZ"
 *       private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *       class Darling\PHPTextTypes\classes\strings\AlphanumericText#43 (2) {
 *         ...
 *       }
 *     }
 *     'sub_sub_array' =>
 *     array(4) {
 *       [0] =>
 *       class Darling\PHPTextTypes\classes\strings\Id#38 (2) {
 *         ...
 *       }
 *       [1] =>
 *       array(4) {
 *         ...
 *       }
 *       [2] =>
 *       double(1.2)
 *       [3] =>
 *       array(0) {
 *         ...
 *       }
 *     }
 *   }
 *   'foo' =>
 *   string(3) "bar"
 *   'id' =>
 *   class Darling\PHPTextTypes\classes\strings\Id#19 (2) {
 *     private string $string =>
 *     string(71) "8auyxWPvjHED83bZLfjDEw1kYMQ59n5820TsrRlr9P57pvgMGmpU4gPZL04BdBf9mHAyqne"
 *     private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *     class Darling\PHPTextTypes\classes\strings\AlphanumericText#69 (2) {
 *       private string $string =>
 *       string(71) "8auyxWPvjHED83bZLfjDEw1kYMQ59n5820TsrRlr9P57pvgMGmpU4gPZL04BdBf9mHAyqne"
 *       private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *       class Darling\PHPTextTypes\classes\strings\Text#56 (1) {
 *         ...
 *       }
 *     }
 *   }
 *   'closure' =>
 *   class Closure#54 (1) {
 *       virtual $closure =>
 *       "$this->Darling\PHPMockingUtilities\classes\mock\values\{closure}"
 *     public $this =>
 *     class Darling\PHPMockingUtilities\classes\mock\values\MockClosure#46 (0) {
 *     }
 *   }
 *   'second_sub_array' =>
 *   array(1) {
 *     [0] =>
 *     array(2) {
 *       [0] =>
 *       array(2) {
 *         ...
 *       }
 *       [1] =>
 *       class stdClass#66 (0) {
 *         ...
 *       }
 *     }
 *   }
 * }
 */

