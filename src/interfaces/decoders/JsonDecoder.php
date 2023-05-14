<?php

namespace Darling\PHPJsonUtilities\interfaces\decoders;

use \Darling\PHPJsonUtilities\interfaces\encoded\data\Json;

/**
 * A JsonDecoder can be used to decode data that was encoded
 * as Json.
 *
 * @example
 *
 * ```
 * $json = new \Darling\PHPJsonUtilities\classes\encoded\data\Json(
 *     new \stdClass()
 * );
 *
 * var_dump($jsonDecoder->decode($json));
 *
 * // example output:
 * string(2) "{}"
 *
 * ```
 */
interface JsonDecoder
{

    public function decode(Json $json): mixed;

}

