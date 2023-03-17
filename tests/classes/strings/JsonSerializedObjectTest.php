<?php

namespace PHPJsonUtilitiesTest\tests\classes\strings;

use Darling\PHPJsonUtilities\classes\strings\JsonSerializedObject;
use Darling\PHPJsonUtilities\tests\interfaces\strings\JsonSerializedObjectTestTrait;
use Darling\PHPJsonUtilities\tests\classes\strings\JsonStringTest;

class JsonSerializedObjectTest extends JsonStringTest
{

    use JsonSerializedObjectTestTrait;

    protected function setUp(): void
    {
        $string = $this->randomChars();
        $this->setExpectedString($string);
        $this->setTextTestInstance(new JsonSerializedObject($string));
    }

}
