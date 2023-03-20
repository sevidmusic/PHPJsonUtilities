<?php

namespace Darling\PHPJsonUtilities\tests\classes\strings;

use Darling\PHPJsonUtilities\classes\strings\JsonString;
use Darling\PHPJsonUtilities\tests\interfaces\strings\JsonStringTestTrait;
use Darling\PHPTextTypes\Tests\classes\strings\TextTest;

class JsonStringTest extends TextTest
{

    use JsonStringTestTrait;

    protected function setUp(): void
    {
        $string = $this->randomChars();
        $this->setExpectedString($string);
        $this->setTextTestInstance(new JsonString($string));
    }

}
