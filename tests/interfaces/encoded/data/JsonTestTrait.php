<?php

namespace Darling\PHPJsonUtilities\tests\interfaces\encoded\data;

use \Darling\PHPJsonUtilities\interfaces\encoded\data\Json;
use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;

/**
 * The JsonTestTrait defines common tests for implementations of
 * the Json interface.
 *
 * @see Json
 *
 */
trait JsonTestTrait
{

    /**
     * @var Json $json An instance of a Json implementation to test.
     */
    private Json $json;

    private string $expectedJsonString;

    /**
     * Set up an instance of a Json implementation to test.
     *
     * This method must set the expected json string
     * via the setExpectedJsonString() method.
     *
     * This method must also set the Json implementation instance
     * to be tested via the setJsonTestInstance() method.
     *
     * This method may also be used to perform any additional setup
     * required by the implementation being tested.
     *
     * @return void
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
     * @param Json $jsonTestInstance An instance of an implementation
     *                               of the Json interface to test.
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

    /**
     * Use the specified $data to determine and set the string that
     * is expected to be returned by the __toString() method defined
     * by the Json instance being tested.
     *
     * @return void
     *
     */
    protected function setExpectedJsonString(mixed $data): void
    {
        $this-> expectedJsonString = $this->encodeMixedValueAsJson(
            $data
        );
    }

    /**
     * Encode a value of any type as json.
     *
     * @return string
     *
     */
    protected function encodeMixedValueAsJson(mixed $data): string
    {
        return match(gettype($data)) {
            'object' => $this->encodeObjectAsJson($data),
            'array' => $this->encodeArrayAsJson($data),
            default => strval($this->jsonEncode($data)),
        };
    }

    /**
     * Recursively encode an array as json.
     *
     * Objects in the array will also be properly encoded as json.
     *
     * @param array<mixed> $array
     *
     * @return string
     *
     */
    private function encodeArrayAsJson(array $array): string
    {
        return $this->jsonEncode(
            $this->encodeObjectsInArrayAsJson($array)
        );
    }

    /**
     * Recursively encode objects in the specified array as json,
     * and return the modified array.
     *
     * @param array<mixed> $array
     *
     * @return array<mixed>
     *
     */
    private function encodeObjectsInArrayAsJson(array $array): array
    {
        foreach($array as $key => $value) {
            if(is_array($value)) {
                $array[$key] = $this->encodeObjectsInArrayAsJson(
                    $value
                );
            }
            if(is_object($value)) {
                $array[$key] = $this->encodeObjectAsJson($value);
            }
        }
        return $array;
    }

    /**
     * Encode an object as json, including it's property data.
     *
     * @return string
     *
     */
    private function encodeObjectAsJson(object $object): string
    {
        $propertyData = [];
        $objectReflection = $this->objectReflection($object);
        foreach(
            $objectReflection->propertyValues()
            as
            $propertyName => $propertyValue
        ) {
            $propertyData[$propertyName] =
                match(gettype($propertyValue)) {
                    'object' => $this->encodeObjectAsJson(
                        $propertyValue
                    ),
                    'array' => $this->encodeObjectsInArrayAsJson(
                        $propertyValue
                    ),
                    default => $propertyValue,
                };
        }
        return $this->jsonEncode(
            [
                self::CLASS_INDEX =>
                    $objectReflection->type()->__toString(),
                self::DATA_INDEX => $propertyData
            ]
        );
    }

    /**
     * Return an instance of of an ObjectReflection that reflects
     * the specified $object.
     *
     * @return ObjectReflection
     *
     */
    private function objectReflection(
        object $object
    ): ObjectReflection
    {
        return new ObjectReflection($object);
    }

    /**
     * Encode the specified $data as json.
     *
     * @return string
     *
     */
    private function jsonEncode(mixed $data): string
    {
        return strval(
            json_encode(
                $data,
                JSON_PRESERVE_ZERO_FRACTION,
                2147483647
            )
        );
    }
    /**
     * Test that the __toString() method returns the expected json
     * string.
     *
     * @return void
     *
     * @covers \Darling\PHPJsonUtilities\classes\encoded\data\Json::__toString()
     *
     * @group JsonTests
     *
     */
    public function test___toString_returns_the_expected_json_string(): void
    {
        $this->assertEquals(
            $this->expectedJsonString,
            $this->jsonTestInstance()->__toString(),
            $this->testFailedMessage(
                $this->jsonTestInstance(),
                '__toString',
                'return the expected json string'
            )
        );
    }

    /**
     * Test that the CLASS_INDEX constant is assigned the
     * string: `__class__`
     *
     * @return void
     *
     * @covers Json::CLASS_INDEX
     *
     * @group JsonTests
     *
     */
    public function test_CLASS_INDEX_is_assigned_the_string___class__(): void
    {
        $this->assertEquals(
            '__class__',
            $this->jsonTestInstance()::CLASS_INDEX,
            $this->testFailedMessage(
                $this->jsonTestInstance(),
                '',
                'the CLASS_INDEX constant must be assigned the ' .
                'string __class__'
            )
        );
    }

    /**
     * Test that the DATA_INDEX constant is assigned the
     * string: `__data__ `
     *
     * @return void
     *
     * @covers Json::DATA_INDEX
     *
     * @group JsonTests
     *
     */
    public function test_DATA_INDEX_is_assigned_the_string___data__(): void
    {
        $this->assertEquals(
            '__data__',
            $this->jsonTestInstance()::DATA_INDEX,
            $this->testFailedMessage(
                $this->jsonTestInstance(),
                '',
                'the DATA_INDEX constant must be assigned the ' .
                'string __data__'
            )
        );
    }

}

