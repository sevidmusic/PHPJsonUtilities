<?php

namespace Darling\PHPJsonUtilities\interfaces\encoded\data;

use \Darling\PHPTextTypes\interfaces\strings\Text;

/**
 * Json is Text whose string value is a valid json string.
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

    public const CLASS_INDEX = '__class__';

    public const DATA_INDEX = '__data__';

    /**
     * Return a valid json string.
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

