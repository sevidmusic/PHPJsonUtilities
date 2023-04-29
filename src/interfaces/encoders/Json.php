<?php

namespace Darling\PHPJsonUtilities\interfaces\encoders;

use \Darling\PHPTextTypes\interfaces\strings\Text;

/**
 * Json can be used to encode data as a json string.
 *
 * @example
 *
 * ```
 * echo $json;
 *
 * // example output
 * ["Some data","encoded as json"]
 *
 * ```
 */
interface Json extends Text
{

    /**
     * Return the data encoded as a json string.
     *
     * @return string
     *
     * @example
     *
     * ```
     * var_dump($json->__toString());
     *
     * // example output
     * string(31) "["Some data","encoded as json"]"
     *
     * ```
     *
     */
    public function __toString(): string;

}

