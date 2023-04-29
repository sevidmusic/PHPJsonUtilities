<?php

namespace Darling\PHPJsonUtilities\classes\encoders;

use Darling\PHPJsonUtilities\interfaces\encoders\Json as JsonInterface;
use \Darling\PHPTextTypes\classes\strings\Text;

class Json extends Text implements JsonInterface
{

    /**
     * Instantiate a Json instance for the specified $data.
     *
     * If the specified $data is not a valid json string,
     * it will be enocded as json.
     *
     * If the specified $data is a valid json string, and
     * the $dataIsJson parameter is set to true, then the
     * $data will be used as is.
     *
     * @example
     *
     * ```
     *
     * ```
     *
     */
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

