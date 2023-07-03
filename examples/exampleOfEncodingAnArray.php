<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * an array as json.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAnArray.php
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
use \Darling\PHPMockingUtilities\classes\mock\values\MockBool;
use \Darling\PHPMockingUtilities\classes\mock\values\MockClosure;
use \Darling\PHPMockingUtilities\classes\mock\values\MockFloat;
use \Darling\PHPMockingUtilities\classes\mock\values\MockInt;
use \Darling\PHPMockingUtilities\classes\mock\values\MockMixedValue;
use \Darling\PHPMockingUtilities\classes\mock\values\MockString;
use \Darling\PHPTextTypes\classes\strings\Id;

$bool = new MockBool();
$closure = new MockClosure();
$float = new MockFloat();
$int = new MockInt();
$mixed = new MockMixedValue();
$string = new MockString();

/**
 * Example of encoding an array.
 *
 * Note: Nested objects and arrays will also be properly encoded.
 *
 */
$array = [
    $bool->value(),
    $closure->value(),
    $float->value(),
    $int->value(),
    $mixed->value(),
    $string->value(),
    'nested-array' => [
        [
            new Id(),
            new Id(),
            new Id(),
        ]
    ]
];
$jsonEncodedArray = new Json($array);

echo $jsonEncodedArray . PHP_EOL;

/**
 * example output:
 *
 * {"0":false,"1":"{\"__class__\":\"Closure\",\"__data__\":[]}","2":549409.875,"3":-6064629463085977541,"4":true,"5":"MockStringLCQeRy6euDGKpPETYHCJzfzWZo3tCOAq4lkrtp7","nested-array":[["{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"VEQ9qiC72OaZRAHtpZHCb2An7cdwQI8xi1331UmK3F1uYFV5NkDfv8jRSO8MIZMN6P6quYokyBmv\\\\\\\"}}\\\",\\\"string\\\":\\\"VEQ9qiC72OaZRAHtpZHCb2An7cdwQI8xi1331UmK3F1uYFV5NkDfv8jRSO8MIZMN6P6quYokyBmv\\\"}}\",\"string\":\"VEQ9qiC72OaZRAHtpZHCb2An7cdwQI8xi1331UmK3F1uYFV5NkDfv8jRSO8MIZMN6P6quYokyBmv\"}}","{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"S7yzDlx4A4a9p1xY6LEPQeu3HO0wAkM6OtToFnFURjlFDaKIeuHsHbNIt6RsxuZqcg9ZBNmym2\\\\\\\"}}\\\",\\\"string\\\":\\\"S7yzDlx4A4a9p1xY6LEPQeu3HO0wAkM6OtToFnFURjlFDaKIeuHsHbNIt6RsxuZqcg9ZBNmym2\\\"}}\",\"string\":\"S7yzDlx4A4a9p1xY6LEPQeu3HO0wAkM6OtToFnFURjlFDaKIeuHsHbNIt6RsxuZqcg9ZBNmym2\"}}","{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"JLiEO9SubUzhiFHgfkbzu2Ly1LNI9XCYyHMhl5eApcPwjzw88tP2TQp474Udm\\\\\\\"}}\\\",\\\"string\\\":\\\"JLiEO9SubUzhiFHgfkbzu2Ly1LNI9XCYyHMhl5eApcPwjzw88tP2TQp474Udm\\\"}}\",\"string\":\"JLiEO9SubUzhiFHgfkbzu2Ly1LNI9XCYyHMhl5eApcPwjzw88tP2TQp474Udm\"}}"]]}
 */

