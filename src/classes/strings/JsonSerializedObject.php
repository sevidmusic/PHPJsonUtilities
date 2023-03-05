<?php

namespace Darling\PHPJsonUtilities\classes\strings;

use \Darling\PHPJsonUtilities\classes\strings\JsonString;
use \Darling\PHPJsonUtilities\interfaces\strings\JsonSerializedObject  as JsonSerializedObjectInterface;
use \stdClass;

class JsonSerializedObject extends JsonString implements JsonSerializedObjectInterface
{

    public function objectInstance(): object
    {
        return new stdClass();
    }

}

