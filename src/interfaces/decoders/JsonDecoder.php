<?php

namespace Darling\PHPJsonUtilities\interfaces\decoders;

use \Darling\PHPJsonUtilities\interfaces\encoded\data\Json;

/**
 * A JsonDecoder can be used to decode Json.
 *
 * @example
 *
 * ```
 * var_dump($jsonDecoder->decode($json));
 *
 * // example output:
 * class Darling\PHPTextTypes\classes\strings\Text#10 (1) {
 *   private string $string =>
 *   string(3) "Foo"
 * }
 *
 * ```
 *
 */
interface JsonDecoder
{

    public function decode(Json $json): mixed;

    public function decodeJsonString(string $json): mixed;

}

