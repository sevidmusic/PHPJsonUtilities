<?php

namespace Darling\PHPJsonUtilities\tests\dev\test\classes;

use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\Name;

final class TestClassA
{

    private mixed $uninitialized;

    public function __construct(private Id $id, private Name $name) {}


    public function id(): Id
    {
        $this->uninitialized = $this->id;
        return $this->id;
    }

    public function name(): Name
    {
        $this->uninitialized = $this->name;
        return $this->name;
    }

    public function uninitialized(): mixed
    {
        return $this->uninitialized;
    }

}
