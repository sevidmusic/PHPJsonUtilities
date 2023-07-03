<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a Json instance as json, and decode it via a JsonDecoder instance.
 *
 * Note:
 *
 * When a Json instance is used to encode another Json instance no
 * encoding actually occurs, instead the Json instance performing
 * the encoding becomes a clone of the Json instance being encoded.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAJsonInstance.php
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
use \Darling\PHPTextTypes\classes\strings\Id;


/**
 * Example of encoding an jsonInstance:
 */
$jsonInstance = new Json(new Id());

$jsonEncodedJsonInstance = new Json($jsonInstance);

$jsonDecoder = new JsonDecoder();

echo 'original json instance' . PHP_EOL;
var_dump($jsonInstance);

echo 'decoded json instance' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedJsonInstance));

/**
 * Note:
 *
 * A JsonDecoder will always decode valid json.
 *
 * If the encoded value was a Json instance then it will
 * be completely decoded by the JsonDecoder->decode() method.
 *
 * example output:
 *
 * ```
 * original json instance
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAJsonInstance.php:47:
 * class Darling\PHPJsonUtilities\classes\encoded\data\Json#3 (1) {
 *   private string $string =>
 *   string(580) "{"__class__":"Darling\\PHPTextTypes\\classes\\strings\\Id","__data__":{"text":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\AlphanumericText\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\Text\\\",\\\"__data__\\\":{\\\"string\\\":\\\"ghnjyBzmZprwwvSKIKFRFd0ibaoVUZ9WACbBEcXUwEeLq1MHrfxXuI01Op41GQ8lWQe6Ylxh\\\"}}\",\"string\":\"GhnjyBzmZprwwvSKIKFRFd0ibaoVUZ9WACbBEcXUwEeLq1MHrfxXuI01Op41GQ8lWQe6Ylxh\"}}","string":"GhnjyBz"...
 * }
 * decoded json instance
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAJsonInstance.php:50:
 * class Darling\PHPTextTypes\classes\strings\Id#13 (2) {
 *   private string $string =>
 *   string(72) "GhnjyBzmZprwwvSKIKFRFd0ibaoVUZ9WACbBEcXUwEeLq1MHrfxXuI01Op41GQ8lWQe6Ylxh"
 *   private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *   class Darling\PHPTextTypes\classes\strings\AlphanumericText#18 (2) {
 *     private string $string =>
 *     string(72) "GhnjyBzmZprwwvSKIKFRFd0ibaoVUZ9WACbBEcXUwEeLq1MHrfxXuI01Op41GQ8lWQe6Ylxh"
 *     private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *     class Darling\PHPTextTypes\classes\strings\Text#10 (1) {
 *       private string $string =>
 *       string(72) "ghnjyBzmZprwwvSKIKFRFd0ibaoVUZ9WACbBEcXUwEeLq1MHrfxXuI01Op41GQ8lWQe6Ylxh"
 *     }
 *   }
 * }
 *
 * ```
 *
 */
