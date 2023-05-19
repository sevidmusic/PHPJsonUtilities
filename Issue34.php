<?php

require_once(
    __DIR__ .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPTextTypes\classes\strings\Id;

$id = new Id();

$array = [$id];

$jsonEncodedArray = new Json($array);

echo $jsonEncodedArray;

// actual output:
/**
[{}]
*/

// expected output:
/**
["{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"mV0IGahkd5T4SrXAdigWFvwGycLaFDKjUlLz2yK3vZXt49DbwxqMj6p26eWhcPCLu5ZMHFSmZcvOyBQP\\\\\\\"}}\\\",\\\"string\\\":\\\"MV0IGahkd5T4SrXAdigWFvwGycLaFDKjUlLz2yK3vZXt49DbwxqMj6p26eWhcPCLu5ZMHFSmZcvOyBQP\\\"}}\",\"string\":\"MV0IGahkd5T4SrXAdigWFvwGycLaFDKjUlLz2yK3vZXt49DbwxqMj6p26eWhcPCLu5ZMHFSmZcvOyBQP\"}}"]
 */

