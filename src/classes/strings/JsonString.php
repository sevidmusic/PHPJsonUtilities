<?php

namespace Darling\PHPJsonUtilities\classes\strings;

use \Darling\PHPTextTypes\classes\strings\Text;
use \Darling\PHPJsonUtilities\interfaces\strings\JsonString as JsonStringInterface;

class JsonString extends Text implements JsonStringInterface
{

    public function __construct(private string $json)
    {
        parent::__construct($this->json);
    }

    public function __toString(): string
    {
        return $this->json;
    }

}

