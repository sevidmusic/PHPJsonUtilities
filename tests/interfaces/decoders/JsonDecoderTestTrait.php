<?php

namespace Darling\PHPJsonUtilities\tests\interfaces\decoders;

use Darling\PHPJsonUtilities\interfaces\decoders\JsonDecoder;

/**
 * The JsonDecoderTestTrait defines common tests for
 * implementations of the JsonDecoder interface.
 *
 * @see JsonDecoder
 *
 */
trait JsonDecoderTestTrait
{

    /**
     * @var JsonDecoder $jsonDecoder
     *                              An instance of a
     *                              JsonDecoder
     *                              implementation to test.
     */
    protected JsonDecoder $jsonDecoder;

    /**
     * Set up an instance of a JsonDecoder implementation to test.
     *
     * This method must also set the JsonDecoder implementation instance
     * to be tested via the setJsonDecoderTestInstance() method.
     *
     * This method may also be used to perform any additional setup
     * required by the implementation being tested.
     *
     * @return void
     *
     * @example
     *
     * ```
     * protected function setUp(): void
     * {
     *     $this->setJsonDecoderTestInstance(
     *         new \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder()
     *     );
     * }
     *
     * ```
     *
     */
    abstract protected function setUp(): void;

    /**
     * Return the JsonDecoder implementation instance to test.
     *
     * @return JsonDecoder
     *
     */
    protected function jsonDecoderTestInstance(): JsonDecoder
    {
        return $this->jsonDecoder;
    }

    /**
     * Set the JsonDecoder implementation instance to test.
     *
     * @param JsonDecoder $jsonDecoderTestInstance
     *                              An instance of an
     *                              implementation of
     *                              the JsonDecoder
     *                              interface to test.
     *
     * @return void
     *
     */
    protected function setJsonDecoderTestInstance(
        JsonDecoder $jsonDecoderTestInstance
    ): void
    {
        $this->jsonDecoder = $jsonDecoderTestInstance;
    }

}

