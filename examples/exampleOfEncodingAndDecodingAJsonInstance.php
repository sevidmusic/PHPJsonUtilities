<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a Json instance as json, and decode it via a JsonDecoder instance.
 *
 * Note:
 *
 * When a Json instance is used to encode another Json instance no
 * encoding actually occurs, instead the Json instance performing
 * the encoding becomes a clone of the Json instance being encoded.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAJsonInstance.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPTextTypes\classes\strings\Id;


/**
 * Example of encoding an jsonInstance:
 */
$jsonInstance = new Json(new Id());

$jsonEncodedJsonInstance = new Json($jsonInstance);

echo $jsonInstance . PHP_EOL;
echo $jsonEncodedJsonInstance . PHP_EOL;

/**
 * example output:
 *
 * {"__class__":"Darling\\PHPTextTypes\\classes\\strings\\Id","__data__":{"text":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\AlphanumericText\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\Text\\\",\\\"__data__\\\":{\\\"string\\\":\\\"2h6YHSSUpZp5T1Q3iaYgqxthm8n3FWGeycV8AsEr9UhzuvYvD3JWyBkbsDzT0f\\\"}}\",\"string\":\"2h6YHSSUpZp5T1Q3iaYgqxthm8n3FWGeycV8AsEr9UhzuvYvD3JWyBkbsDzT0f\"}}","string":"2h6YHSSUpZp5T1Q3iaYgqxthm8n3FWGeycV8AsEr9UhzuvYvD3JWyBkbsDzT0f"}}
 * {"__class__":"Darling\\PHPTextTypes\\classes\\strings\\Id","__data__":{"text":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\AlphanumericText\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\Text\\\",\\\"__data__\\\":{\\\"string\\\":\\\"2h6YHSSUpZp5T1Q3iaYgqxthm8n3FWGeycV8AsEr9UhzuvYvD3JWyBkbsDzT0f\\\"}}\",\"string\":\"2h6YHSSUpZp5T1Q3iaYgqxthm8n3FWGeycV8AsEr9UhzuvYvD3JWyBkbsDzT0f\"}}","string":"2h6YHSSUpZp5T1Q3iaYgqxthm8n3FWGeycV8AsEr9UhzuvYvD3JWyBkbsDzT0f"}}
 *
 */

//decoder
$jsonDecoder = new JsonDecoder();

