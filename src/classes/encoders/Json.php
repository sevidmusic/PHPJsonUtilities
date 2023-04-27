<?php

namespace Darling\PHPJsonUtilities\classes\encoders;

use Darling\PHPJsonUtilities\interfaces\encoders\Json as JsonInterface;
use \Darling\PHPTextTypes\classes\strings\Text;

class Json extends Text implements JsonInterface
{

    public function __construct(mixed $data, bool $dataIsJson = false)
    {
        parent::__construct(
            match(is_string($data) && $dataIsJson) {
                true => $data,
                default => strval(json_encode($data)),
            }
        );
    }
}

