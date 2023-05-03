<?php

namespace Darling\PHPJsonUtilities\tests\interfaces\decoders;

use \Darling\PHPJsonUtilities\classes\encoded\data\Json as JsonInstance;
use \Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\PrivateStaticProperties;
use \Darling\PHPJsonUtilities\interfaces\decoders\JsonDecoder;
use \Darling\PHPJsonUtilities\interfaces\encoded\data\Json;
use \Darling\PHPMockingUtilities\classes\mock\values\MockClassInstance;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPTextTypes\classes\strings\ClassString;
use \Darling\PHPTextTypes\classes\strings\UnknownClass;
use \ReflectionClass;

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

    private function JsonInstance(mixed $data): Json
    {
        return new JsonInstance($data);
    }

    private function randomData(): mixed
    {
        $data = [
            #$this->randomChars(),
            #$this->randomFloat(),
            #$this->randomClassStringOrObjectInstance(),
            #$this->randomObjectInstance(),
            new PrivateStaticProperties(),
        ];
        return $data[array_rand($data)];
    }

    private function decodeJson(Json $json): mixed
    {
        return match(
            $this->isAJsonEncodedObject($json)
        ) {
            true => $this->decodeJsonToObject($json),
            default => json_decode($json->__toString()),
        };
    }

    public function isAJsonEncodedObject(Json $json): bool
    {
        return str_contains($json->__toString(), Json::CLASS_INDEX)
            && str_contains($json->__toString(), Json::DATA_INDEX);
    }

    private function decodeJsonToObject(Json $json): object {
        $data = json_decode($json, true);
        if (
            is_array($data)
            &&
            isset($data[Json::CLASS_INDEX])
            &&
            isset($data[Json::DATA_INDEX])
        ) {
            $class = $data[Json::CLASS_INDEX];
            $mockClassInstance = new MockClassInstance(
                new Reflection(new ClassString($class))
            );
            $object = $mockClassInstance->mockInstance();
            $reflection = new ReflectionClass($object);
            while ($reflection) {
                foreach (
                    $data[Json::DATA_INDEX]
                    as
                    $name => $originalValue
                ) {
                    if(
                        is_string($originalValue)
                        &&
                        (false !== json_decode($originalValue))
                    ) {
                        if(
                            str_contains(
                                $originalValue,
                                Json::CLASS_INDEX
                            )
                            &&
                            str_contains(
                                $originalValue,
                                Json::DATA_INDEX
                            )
                        ) {
                            $originalValue = $this->decodeJsonToObject(
                                new JsonInstance($originalValue)
                            );
                        }
                    }
                    if ($reflection->hasProperty($name)) {
                        $property = $reflection->getProperty($name);
                        $property->setAccessible(true);
                        $property->setValue($object, $originalValue);
                    }
                }
                $reflection = $reflection->getParentClass();
            }
            return $object;
        }
        return new UnknownClass();
    }

    /**
     * Test that the decode() method returns the original data.
     *
     * @covers JsonDecoder->decode()
     *
     */
    public function test_decode_returns_the_original_data(): void
    {
        $data = $this->randomData();
        $json = $this->JsonInstance($data);
        $this->assertEquals(
            $this->decodeJson($json),
            $this->jsonDecoderTestInstance()->decode($json),
            $this->testFailedMessage(
                $this->jsonDecoderTestInstance(),
                'decode',
                'return the original data'
            ),
        );
    }
}

