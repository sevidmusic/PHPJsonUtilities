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

$objectInstance = new Id();

$jsonEncodedObject = new Json($objectInstance);

echo $jsonEncodedObject . PHP_EOL;

// example output:
// {"__class__":"Darling\\PHPTextTypes\\classes\\strings\\Id","__data__":{"text":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\AlphanumericText\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\Text\\\",\\\"__data__\\\":{\\\"string\\\":\\\"IxVFLvhpJCzvuEyoYjt3TqQL7xE4lSKaFgNhOTwRUjN8yiizaF7gfADZHVl7WJfmHdg52i0Nrl12Kc\\\"}}\",\"string\":\"IxVFLvhpJCzvuEyoYjt3TqQL7xE4lSKaFgNhOTwRUjN8yiizaF7gfADZHVl7WJfmHdg52i0Nrl12Kc\"}}","string":"IxVFLvhpJCzvuEyoYjt3TqQL7xE4lSKaFgNhOTwRUjN8yiizaF7gfADZHVl7WJfmHdg52i0Nrl12Kc"}}

$array = [1, 'foo' => 'bar',[null, false]];

$jsonEncodedArray = new Json($array);

echo $jsonEncodedArray . PHP_EOL;

// example output:
// {"0":1,"foo":"bar","1":[null,false]}

