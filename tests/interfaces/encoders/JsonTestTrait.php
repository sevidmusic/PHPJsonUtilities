<?php

namespace Darling\PHPJsonUtilities\tests\interfaces\encoders;

use Darling\PHPJsonUtilities\interfaces\encoders\Json;
use \Directory;
use \Closure;
use \RuntimeException;
use \Darling\PHPReflectionUtilities\interfaces\utilities\Reflection as ReflectionInterface;


/**
 * The JsonTestTrait defines common tests for
 * implementations of the Json interface.
 *
 * @see Json
 *
 */
trait JsonTestTrait
{

    /**
     * @var Json $json
     *                              An instance of a
     *                              Json
     *                              implementation to test.
     */
    protected Json $json;

    private mixed $originalData;

    /**
     * Set up an instance of a Json implementation to test.
     *
     * This method must also set the Json implementation instance
     * to be tested via the setJsonTestInstance() method.
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
     *     $this->setJsonTestInstance(
     *         new \Darling\PHPJsonUtilities\classes\encoders\Json()
     *     );
     * }
     *
     * ```
     *
     */
    abstract protected function setUp(): void;

    /**
     * Return the Json implementation instance to test.
     *
     * @return Json
     *
     */
    protected function jsonTestInstance(): Json
    {
        return $this->json;
    }

    /**
     * Set the Json implementation instance to test.
     *
     * @param Json $jsonTestInstance
     *                              An instance of an
     *                              implementation of
     *                              the Json
     *                              interface to test.
     *
     * @return void
     *
     */
    protected function setJsonTestInstance(
        Json $jsonTestInstance
    ): void
    {
        $this->json = $jsonTestInstance;
    }

    protected function setOriginalData(mixed $data): void
    {
        $this->originalData = $data;
    }

    private function expectExceptionIfOriginalDataCannotBeEncodedAsJson(): void
    {
        if(
            $this->dataIsAJsonImplementationInstance()
            ||
            $this->dataIsAReflectionImplementationInstance()
            ||
            $this->dataIsAClosure()
            ||
            $this->dataIsADirectory()
        ) {
            $this->expectException(RuntimeException::class);
        }

    }

    private function dataIsAJsonImplementationInstance(): bool
    {
        return is_object($this->originalData)
        &&
        in_array(Json::class, class_implements($this->originalData::class));
    }

    private function dataIsAReflectionImplementationInstance(): bool
    {
        return is_object($this->originalData)
        &&
        in_array(
            ReflectionInterface::class,
            class_implements($this->originalData::class),
        );
    }

    private function dataIsAClosure(): bool
    {
        return is_object($this->originalData)
        &&
        Closure::class
        ===
        $this->originalData::class;
    }

    private function dataIsADirectory(): bool
    {
        return is_object($this->originalData)
        &&
        Directory::class === $this->originalData::class;
    }
}

