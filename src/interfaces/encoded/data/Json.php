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
 * {"__class__":"Darling\\PHPTextTypes\\classes\\strings\\Text","__data__":{"string":"Foo"}}
 *
 * ```
 */
interface Json extends Text
{

    /**
     * @const CLASS_INDEX Expected to be used to identify the index
     *                    of the json value that indicates an encoded
     *                    object's type.
     */
    public const CLASS_INDEX = '__class__';

    /**
     * @const DATA_INDEX Expected to be used to identify the index
     *                   of the json value used to store an encoded
     *                   object's data.
     */
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

