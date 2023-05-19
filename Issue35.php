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

$id = new Id();

$array = [$id];

$jsonEncodedArray = new Json($array);

$decodedArray = $jsonDecoder->decode($jsonEncodedArray);

var_dump($decodedArray);

// actual output:
/**
array(1) {
  [0] =>
  class stdClass#7 (0) {
  }
}
 */

// expected output:
/**
array(1) {
  [0] =>
  class Darling\PHPTextTypes\classes\strings\Id#2 (2) {
    private string $string =>
    string(77) "Pf5o0ZOe9K8bCXWj8nGOxohGGhyyHeCEmbuvVXH6wUD9mLInjy1zi5gqwjUMnqz2dkKobMe8zT5ba"
    private Darling\PHPTextTypes\interfaces\strings\Text $text =>
    class Darling\PHPTextTypes\classes\strings\AlphanumericText#4 (2) {
      private string $string =>
      string(77) "Pf5o0ZOe9K8bCXWj8nGOxohGGhyyHeCEmbuvVXH6wUD9mLInjy1zi5gqwjUMnqz2dkKobMe8zT5ba"
      private Darling\PHPTextTypes\interfaces\strings\Text $text =>
      class Darling\PHPTextTypes\classes\strings\Text#5 (1) {
        ...
      }
    }
  }
}
 */
