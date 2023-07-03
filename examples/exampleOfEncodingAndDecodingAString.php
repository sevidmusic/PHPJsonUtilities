<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a string as json.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAString.php
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
use \Darling\PHPMockingUtilities\classes\mock\values\MockString;

/**
 * Example of encoding a string:
 */
$string = new MockString();

$jsonEncodedString = new Json($string->value());

echo $jsonEncodedString . PHP_EOL;

/**
 * example output:
 *
 * "MockString6SWnnT5kaibcMMIjjFsqasQ7vfjwyfKlpqiVNEJ"
 *
 */

//decoder
