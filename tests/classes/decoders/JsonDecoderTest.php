<?php

namespace Darling\PHPJsonUtilities\tests\classes\decoders;

use Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use Darling\PHPJsonUtilities\tests\PHPJsonUtilitiesTest;
use Darling\PHPJsonUtilities\tests\interfaces\decoders\JsonDecoderTestTrait;

class JsonDecoderTest extends PHPJsonUtilitiesTest
{

    /**
     * The JsonDecoderTestTrait defines
     * common tests for implementations of the
     * Darling\PHPJsonUtilities\interfaces\decoders\JsonDecoder
     * interface.
     *
     * @see JsonDecoderTestTrait
     *
     */
    use JsonDecoderTestTrait;

    public function setUp(): void
    {
        $this->setJsonDecoderTestInstance(
            new JsonDecoder()
        );
    }
}

