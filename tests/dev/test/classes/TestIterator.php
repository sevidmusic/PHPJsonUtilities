<?php

namespace Darling\PHPJsonUtilities\tests\dev\test\classes;

use \Iterator;

/**
 * This class is used by tests defined by the PHPJsonUtilities library.
 *
 * It should not be used in any other context.
 *
 */

/**
 * @template T
 * @implements Iterator<string>
 */
class TestIterator implements Iterator
{

    /**
     *
     * @param int $position
     * @param array<int, string> $array
     *
     */
    public function __construct(private int $position = 0, private array $array = []) {
        if(empty($this->array)) {
            $this->array = array( "foo", "bar", "baz", "bazzer");
        }
    }

    public function rewind(): void {
        $this->position = 0;
    }

    public function current(): string {
        return $this->array[$this->position];
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
