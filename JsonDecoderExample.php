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

$jsonDecoder = new JsonDecoder();

$objectInstance = new Id();

$jsonEncodedObject = new Json($objectInstance);

$decodedObject = $jsonDecoder->decode($jsonEncodedObject);

var_dump($decodedObject);

/**
 * example output:
 *
 * class Darling\PHPTextTypes\classes\strings\Id#9 (2) {
 *   private string $string =>
 *   string(76) "GlyJ9DGMzRfbqXVvi2Z5orA8p4taCXguejgZNSTimGwo9EaqJjlNFzQLm8NCMFAhk3YlEcWYQwsc"
 *   private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *   class Darling\PHPTextTypes\classes\strings\AlphanumericText#17 (2) {
 *     private string $string =>
 *     string(76) "GlyJ9DGMzRfbqXVvi2Z5orA8p4taCXguejgZNSTimGwo9EaqJjlNFzQLm8NCMFAhk3YlEcWYQwsc"
 *     private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *     class Darling\PHPTextTypes\classes\strings\Text#18 (1) {
 *       private string $string =>
 *       string(76) "GlyJ9DGMzRfbqXVvi2Z5orA8p4taCXguejgZNSTimGwo9EaqJjlNFzQLm8NCMFAhk3YlEcWYQwsc"
 *     }
 *   }
 * }
 *
 */

$array = [1, 'foo' => 'bar',[null, false]];

$jsonEncodedArray = new Json($array);

$decodedArray = $jsonDecoder->decode($jsonEncodedArray);

var_dump($decodedArray);

/**
 * example output:
 *
 * class stdClass#12 (3) {
 *   public $0 =>
 *   int(1)
 *   public $foo =>
 *   string(3) "bar"
 *   public $1 =>
 *   array(2) {
 *     [0] =>
 *     NULL
 *     [1] =>
 *     bool(false)
 *   }
 * }
 *
 */

