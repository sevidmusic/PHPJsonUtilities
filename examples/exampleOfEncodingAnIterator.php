<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a iterator as json.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAnIterator.php
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
use \Darling\PHPTextTypes\classes\strings\Id;

/** @implements Iterator<Id> */
class exampleIterator implements Iterator {
    private int $position = 0;

    /** @var array<Id> $ids */
    private array $ids = [];

    public function __construct(Id ...$ids) {
        foreach($ids as $id) {
            $this->ids[] = $id;
        }
    }

    public function rewind(): void {
        $this->position = 0;
    }

    public function current(): Id {
        return $this->ids[$this->position];
    }

    public function key(): int {
        return $this->position;
    }

    public function next(): void {
        ++$this->position;
    }

    public function valid(): bool {
        return isset($this->array[$this->position]);
    }
}
/**
 * Example of encoding an iterator:
 */
$iterator = new exampleIterator(new Id());

$jsonEncodedIterator = new Json($iterator);

echo $jsonEncodedIterator . PHP_EOL;

/**
 * example output:
 *
 * false
 *
 */

