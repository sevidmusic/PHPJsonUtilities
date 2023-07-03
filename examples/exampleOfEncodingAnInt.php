<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a int as json.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAnInt.php
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
use \Darling\PHPMockingUtilities\classes\mock\values\MockInt;

/**
 * Example of encoding an int:
 */
$int = new MockInt();

$jsonEncodedInt = new Json($int->value());

echo $jsonEncodedInt . PHP_EOL;

/**
 * example output:
 *
 * 2609743170528575717
 *
 */

