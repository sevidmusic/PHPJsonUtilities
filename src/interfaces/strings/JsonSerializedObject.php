<?php

namespace Darling\PHPJsonUtilities\interfaces\strings;

use \Darling\PHPJsonUtilities\interfaces\strings\JsonString;

/**
 * A JsonSerializedObject is a JsonString that represents a php
 * object instance.
 *
 * ```
 * var_dump($jsonSerializedObject->objectInstance());
 *
 * object(stdClass)#1 (2) {
 *   ["foo"]=>
 *   string(3) "bar"
 *   ["baz"]=>
 *   string(6) "bazzer"
 * }
 *
 * var_dump($jsonSerializedObject->__toString());
 *
 * // example output:
 * string(28) "{"foo":"bar","baz":"bazzer"}"
 *
 * ```
 *
 */
interface JsonSerializedObject extends JsonString
{


    /**
     * Return the object instance this JsonSerializedObject
     * represents.
     *
     * @return object
     *
     * @example
     *
     * ```
     * var_dump($jsonSerializedObject->objectInstance());
     * object(stdClass)#1 (2) {
     *   ["foo"]=>
     *   string(3) "bar"
     *   ["baz"]=>
     *   string(6) "bazzer"
     * }
     *
     * ```
     *
     */
    public function objectInstance(): object;

}

