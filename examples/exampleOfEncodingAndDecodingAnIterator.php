<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * an iterator as json, and decode it via a JsonDecoder instance.
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
use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;

/** @implements Iterator<int> */
class exampleIterator implements Iterator {
    private int $position = 0;

    /** @var array<int> $ints */
    private array $ints = [];

    public function __construct(int ...$ints) {
        foreach($ints as $id) {
            $this->ints[] = $id;
        }
    }

    public function rewind(): void {
        $this->position = 0;
    }

    public function current(): int {
        return $this->ints[$this->position];
    }

    public function key(): int {
        return $this->position;
    }

    public function next(): void {
        if($this->position < (count($this->ints) - 1)) {
            ++$this->position;
        } else {
            $this->position = 0;
        }
    }

    public function previous(): void {
        if($this->position > 0) {
            --$this->position;
        } else {
            $this->position = count($this->ints) - 1;
        }
    }

    public function valid(): bool {
        return isset($this->array[$this->position]);
    }
}

/**
 * Example of encoding an iterator:
 */
$iterator = new exampleIterator(1, 2, 3, 4, 5);
$iterator->previous();
$iterator->previous();
$iterator->previous();
$iterator->next();

$jsonEncodedIterator = new Json($iterator);

echo $jsonEncodedIterator . PHP_EOL;

/**
 * example output:
 *
 * {"__class__":"exampleIterator","__data__":{"position":3,"ints":[1,2,3,4,5]}}
 *
 */

//decoder
$jsonDecoder = new JsonDecoder();

