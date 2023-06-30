<?php

namespace Darling\PHPJsonUtilities\tests\dev\test\classes;

class TestClassDefinesReadOnlyProperties {

    public function __construct(private readonly string $foo) {}

    public function foo(): string { return $this->foo; }

}

