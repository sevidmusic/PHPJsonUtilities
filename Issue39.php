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

$associativeArray = [true, false, [1, 2, 3], 'key' => 'value', null];

$jsonEncodedArray = new Json($associativeArray);

$decodedArray = $jsonDecoder->decode($jsonEncodedArray);

var_dump($decodedArray);

var_dump(json_decode($jsonEncodedArray, true));

// actual output:
/**
class stdClass#4 (5) {
  public $0 =>
  bool(true)
  public $1 =>
  bool(false)
  public $2 =>
  array(3) {
    [0] =>
    int(1)
    [1] =>
    int(2)
    [2] =>
    int(3)
  }
  public $key =>
  string(5) "value"
  public $3 =>
  NULL
}
*/

// expected output:
/**
array(5) {
  [0] =>
  bool(true)
  [1] =>
  bool(false)
  [2] =>
  array(3) {
    [0] =>
    int(1)
    [1] =>
    int(2)
    [2] =>
    int(3)
  }
  'key' =>
  string(5) "value"
  [3] =>
  NULL
}
*/
