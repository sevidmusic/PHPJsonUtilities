<?php

namespace Darling\PHPJsonUtilities\tests\interfaces\decoders;

use \Darling\PHPJsonUtilities\classes\encoded\data\Json as JsonInstance;
use \Darling\PHPJsonUtilities\interfaces\decoders\JsonDecoder;
use \Darling\PHPJsonUtilities\interfaces\encoded\data\Json;
use \Darling\PHPMockingUtilities\classes\mock\values\MockClassInstance;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPTextTypes\classes\strings\ClassString;
use \Darling\PHPTextTypes\classes\strings\UnknownClass;
use \Darling\PHPTextTypes\classes\strings\Id;
use \ReflectionClass;
use \ReflectionProperty;

/**
 * The JsonDecoderTestTrait defines common tests for implementations
 * of the JsonDecoder interface.
 *
 * @see JsonDecoder
 *
 */
trait JsonDecoderTestTrait
{

    private string $dataStringIndex = 'string';

    /**
     * @var JsonDecoder $jsonDecoder An instance of a JsonDecoder
     *                               implementation to test.
     */
    protected JsonDecoder $jsonDecoder;


    /**
     * Set up an instance of a JsonDecoder implementation to test.
     *
     * This method must also set the JsonDecoder implementation
     * instance to be tested via the setJsonDecoderTestInstance()
     * method.
     *
     * This method may also be used to perform any additional setup
     * required by the implementation being tested.
     *
     * @return void
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
     * @param JsonDecoder $jsonDecoderTestInstance An instance of an
     *                                             implementation of
     *                                             the JsonDecoder
     *                                             interface to test.
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

    /**
     * Return a JsonInstance that encodes the specified $data.
     *
     * @return JsonInstance
     *
     */
    private function JsonInstance(mixed $data): JsonInstance
    {
        return new JsonInstance($data);
    }

    /**
     * If the specified $value is an object, return it unmodified,
     * otherwise return an instance of an UnknownClass.
     *
     * @return object
     *
     */
    private function objectOrUnknownClass(mixed $value): object
    {
        return match(is_object($value)) {
            true => $value,
            default => new UnknownClass(),
        };
    }

    /**
     * If the specified $value is an object, return an instance of a
     * ClassString for the specified $value.
     *
     * Otherwise return an instance of a ClassString for an
     * UnknownClass.
     *
     * @return ClassString
     *
     */
    private function determineClass(mixed $value): ClassString
    {
        return new ClassString($this->objectOrUnknownClass($value));
    }

    /**
     * Return true if the specified $class defines readonly properties,
     * false otherwise.
     *
     * @return bool
     *
     */
    private function classDefinesReadOnlyProperties(ClassString $class): bool
    {
        $reflection = new Reflection($class);
        foreach($reflection->propertyNames() as $propertyName) {
            if($reflection->reflectionClass()->hasProperty($propertyName)) {
                $reflectedProperty = new ReflectionProperty($class->__toString(), $propertyName);
                if($reflectedProperty->isReadOnly()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Test that the decode() method returns the original data.
     *
     * @covers JsonDecoder->decode()
     *
     * @group JsonDecoderTests
     *
     */
    public function test_decode_returns_the_original_data(): void
    {
        $predefinedTestData = $this->predefinedTestData();
        foreach($predefinedTestData as $data) {
            $json = $this->JsonInstance($data);
            $decodedData = $this->jsonDecoderTestInstance()->decode($json);
            match(
                is_object($data)
                &&
                $this->classDefinesReadOnlyProperties(new ClassString($data))
            ) {
                true =>
                    $this->assertEquals(
                        $this->determineClass($data),
                        $this->determineClass($decodedData),
                        $this->testFailedMessage(
                            $this->jsonDecoderTestInstance(),
                            'decode',
                            'return an object of the same type ' .
                            'as the original object if the original ' .
                            'object is an instance of a class that ' .
                            'defines readonly properties. ' .
                            'If the original object is an instance ' .
                            'of a class that defines readonly ' .
                            'properties it may not be possible to ' .
                            'decode it to it\'s original state.'
                        ),
                    ),
                default =>
                    $this->assertEquals(
                        $data,
                        $decodedData,
                        $this->testFailedMessage(
                            $this->jsonDecoderTestInstance(),
                            'decode',
                            'return the original data'
                        ),
                    )
            };
        }
    }

    /**
     * Test that the decode() method can decode a Json encoded
     * string.
     *
     * @covers JsonDecoder->decode()
     *
     * @group JsonDecoderTests
     *
     */
    public function test_decode_can_decode_a_Json_encoded_string(): void
    {
        $string = str_shuffle('abcdefghijklmnopqrstuvwxyz');
        $json = $this->JsonInstance($string);
        $decodedString = $this->jsonDecoderTestInstance()->decode($json);
        $this->assertEquals(
            $string,
            $decodedString,
            $this->testFailedMessage(
                $this->jsonDecoderTestInstance(),
                'decode',
                'return the original string'
            ),
        );
    }

    /**
     * Test that the decode() method can decode a Json encoded
     * json string.
     *
     * @covers JsonDecoder->decode()
     *
     * @group JsonDecoderTests
     *
     */
    public function test_decode_can_decode_a_Json_encoded_json_string(): void
    {
        $jsonString = json_encode(
            [
                str_shuffle('abcdefghijklmnopqrstuvwxyz'),
                new Id(),
            ]
        );
        $json = $this->JsonInstance($jsonString);
        $decodedJsonString = $this->jsonDecoderTestInstance()->decode($json);
        $this->assertEquals(
            $jsonString,
            $decodedJsonString,
            $this->testFailedMessage(
                $this->jsonDecoderTestInstance(),
                'decode',
                'return the original jsonString'
            ),
        );
    }

    /**
     * Test that the decode() method can decode a Json encoded Json
     * instance.
     *
     * @covers JsonDecoder->decode()
     *
     * @group JsonDecoderTests
     *
     */
    public function test_decode_can_decode_a_Json_instance(): void
    {
        $initialJson = $this->JsonInstance(new Id());
        $json = $this->JsonInstance($initialJson);
        $decodedJson = $this->jsonDecoderTestInstance()->decode($json);
        $this->assertEquals(
            $initialJson,
            $decodedJson,
            $this->testFailedMessage(
                $this->jsonDecoderTestInstance(),
                'decode',
                'return the original string'
            ),
        );
    }

    /**
     * Test that the decode() method can decode a Json encoded array
     * that contained object instances before it was encoded.
     *
     * @covers JsonDecoder->decode()
     *
     * @group JsonDecoderTests
     *
     */
    public function test_decode_can_decode_an_array_that_contains_object_instances(): void
    {
        $array = [new Id(), [new Id(), new Id()]];
        $json = $this->JsonInstance($array);
        $decodedJson = $this->jsonDecoderTestInstance()->decode($json);
        $this->assertEquals(
            $array,
            $decodedJson,
            $this->testFailedMessage(
                $this->jsonDecoderTestInstance(),
                'decode',
                'return the original string'
            ),
        );
    }
}

