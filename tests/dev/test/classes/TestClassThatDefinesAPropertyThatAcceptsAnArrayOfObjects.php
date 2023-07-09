<?php

namespace Darling\PHPJsonUtilities\tests\dev\test\classes;

class TestClassThatDefinesAPropertyThatAcceptsAnArrayOfObjects
{

    /** @var array<int, object> */
    private array $objects = [];

    public function __construct(object ...$objects) {
        foreach($objects as $object) {
            $this->objects[] = $object;
        }
    }

    /**
     * Return an numerically indexed array of objects.
     *
     * @return array<int, object>
     *
     */
    public function objects(): array
    {
        return $this->objects;
    }

}
