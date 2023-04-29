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
     * or an implementation of the JsonInterface, it will
     * be enocded as json if possible.
     *
     * If the $data cannot be encoded the encoded $data
     * will be an empty json object:
     *
     * ```
     * {}
     *
     * ```
     * If the specified $data is an instance of an implementation
     * of the JsonInterface, or if the $dataIsJson parameter is
     * set to true and the specified $data is a valid json string,
     * then the $data will not be encoded as josn.
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

