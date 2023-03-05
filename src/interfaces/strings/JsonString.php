<?php

namespace Darling\PHPJsonUtilities\interfaces\strings;

use \Darling\PHPTextTypes\interfaces\strings\Text;

/**
 * A JsonString represents a valid json string.
 *
 * ```
 * var_dump($jsonString);
 *
 * // example output:
 * string(33) "{"foo":"bar","0":"baz","1":"bin"}"
 *
 * ```
 *
 */
interface JsonString extends Text
{

    /**
     * Returns a valid json string.
     *
     * @return string
     *
     * @example
     *
     * ```
     * var_dump($jsonString);
     *
     * // example output:
     * string(33) "{"foo":"bar","0":"baz","1":"bin"}"
     *
     * ```
     *
     */
    public function __toString(): string;

}

