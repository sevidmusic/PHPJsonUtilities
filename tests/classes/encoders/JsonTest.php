<?php

namespace Darling\PHPJsonUtilities\tests\classes\encoders;

use Darling\PHPJsonUtilities\classes\encoders\Json;
use Darling\PHPJsonUtilities\tests\PHPJsonUtilitiesTest;
use Darling\PHPJsonUtilities\tests\interfaces\encoders\JsonTestTrait;

class JsonTest extends PHPJsonUtilitiesTest
{

    /**
     * The JsonTestTrait defines
     * common tests for implementations of the
     * Darling\PHPJsonUtilities\interfaces\encoders\Json
     * interface.
     *
     * @see JsonTestTrait
     *
     */
    use JsonTestTrait;

    public function setUp(): void
    {
        $values = [
            $this->randomChars(),
            $this->randomObjectInstance(),
        ];
        $data = $values[array_rand($values)];
        $this->setOriginalData($data);
        $this->expectExceptionIfOriginalDataCannotBeEncodedAsJson();
        $this->setJsonTestInstance(
            new Json($data)
        );
    }
}

