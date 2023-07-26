<?php

/**
 * Purpose of this integration test:
 *
 * Test that Iterators can be encoded as json via a Json instance, and
 * that a Json instance used to encode an Iterator can be decoded back
 * to it's original value via a JsonDecoder.
 *
 */

include(
    str_replace(
        'tests' . DIRECTORY_SEPARATOR . 'integration',
        '',
        __DIR__
    ) .'vendor/autoload.php'
);

use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json;

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

$iterator = new exampleIterator(1, 2, 3, 4, 5);
$iterator->previous();
$iterator->previous();
$iterator->previous();
$iterator->next();

$jsonEncodedIterator = new Json($iterator);

$jsonDecoder = new JsonDecoder();

echo "\033[38;5;0m\033[48;5;111mRunning test" . __FILE__ . " \033[48;5;0m";

if(
    $jsonDecoder->decode($jsonEncodedIterator) == $iterator
) {
    echo "\033[38;5;0m\033[48;5;84mPassed\033[48;5;0m";
} else {
    echo "\033[38;5;0m\033[48;5;196mFailed\033[48;5;0m";
}

