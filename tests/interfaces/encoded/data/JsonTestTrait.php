<?php

namespace Darling\PHPJsonUtilities\tests\interfaces\encoded\data;

use Darling\PHPJsonUtilities\interfaces\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json as JsonInsance;
use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPTextTypes\classes\strings\ClassString;
use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Darling\PHPTextTypes\classes\strings\Name;
use \Directory;
use \ReflectionClass;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassDefinesReadOnlyProperties;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassA;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassB;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestIterator;

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

    protected function setExpectedJsonString(mixed $data): void
    {
        $this-> expectedJsonString = $this->encodeMixedValueAsJson(
            $data
        );
    }

    protected function encodeMixedValueAsJson(mixed $data): string
    {
        if(is_object($data)) {
            return $this->encodeObjectAsJson($data);
        }
        return match(gettype($data)) {
            'array' => $this->encodeArrayAsData($data),
            default => strval($this->jsonEncode($data))
        };
    }

    /**
     * Return true if the specified string is a valid json string,
     * false otherwise.
     *
     * @return bool
     *
     */
    private function stringIsAJsonString(string $string): bool
    {
        return (false !== json_decode($string)) && (json_last_error() === JSON_ERROR_NONE);
    }

    /**
     * Return a json encoded version of specified string.
     *
     * If the string is already valid json string it will
     * be returned unmodified.
     *
     * @return string
     *
     */
    private function encodeStringAsJson(string $string): string
    {
        return match($this->stringIsAJsonString($string)) {
            true => $string,
            default => strval($this->jsonEncode($string)),
        };
    }


    /**
     * Encode an array as json, making sure to properly encode
     * objects that exist in the array.
     *
     * @param array<mixed> $array
     *
     * @return string
     *
     */
    private function encodeArrayAsData(array $array): string
    {
        foreach($array as $key => $value) {
            if(is_array($value)) {
                $array[$key] = $this->encodeObjectsInArrayAsJson(
                    $value
                );
                continue;
            }
            if(is_object($value)) {
                $array[$key] = $this->encodeObjectAsJson($value);
            }
        }
        return strval($this->jsonEncode($array));
    }

    /**
     * Recursively encode objects in an array as json.
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
     * Encode an object as json.
     *
     * @return string
     *
     */
    private function encodeObjectAsJson(object $object): string
    {
        $data = [];
        $objectReflection = $this->objectReflection($object);
        foreach($objectReflection->propertyValues() as $propertyName => $propertyValue)
        {
            if(is_object($propertyValue)) {
                $data[$propertyName] = $this->encodeObjectAsJson(
                    $propertyValue
                );
               continue;
            }
            if(is_array($propertyValue)) {
                $propertyValue = $this->encodeObjectsInArrayAsJson($propertyValue);
            }
            $data[$propertyName] = $propertyValue;

        }
        return strval(
            $this->jsonEncode(
                [
                    self::CLASS_INDEX =>
                        $objectReflection->type()->__toString(),
                    self::DATA_INDEX =>
                        $data
                ]
            )
        );
    }

    private function jsonEncode(mixed $data): string
    {
        return strval(json_encode($data, JSON_PRESERVE_ZERO_FRACTION, 2147483647));
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

