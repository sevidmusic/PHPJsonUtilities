<?php

namespace Darling\PHPJsonUtilities\tests\interfaces\encoded\data;

use Darling\PHPJsonUtilities\interfaces\encoded\data\Json;
use \Closure;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json as JsonInsance;
use \Darling\PHPJsonUtilities\tests\PHPJsonUtilitiesTest;
use \Darling\PHPJsonUtilities\tests\interfaces\encoded\data\JsonTestTrait;
use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPReflectionUtilities\interfaces\utilities\Reflection as ReflectionInterface;
use \Darling\PHPTextTypes\classes\strings\ClassString;
use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Directory;
use \ReflectionClass;
use \RuntimeException;

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
     * @example
     *
     * ```
     * public function setUp(): void
     * {
     *     $values = [
     *         $this->randomChars(),
     *         $this->randomObjectInstance(),
     *     ];
     *     $data = $values[array_rand($values)];
     *     $this->setExpectedJsonString($data);
     *     $this->setJsonTestInstance(
     *         new JsonInsance($data)
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
            'string' => $this->encodeStringAsJson($data),
            'array' => $this->encodeArrayAsData($data),
            default => strval(json_encode($data))
        };
    }

    private function stringIsAJsonString(string $string): bool
    {
        return (false !== json_decode($string)) && (json_last_error() === JSON_ERROR_NONE);
    }

    private function encodeStringAsJson(string $string): string
    {
        return match($this->stringIsAJsonString($string)) {
            true => $string,
            default => strval(json_encode($string)),
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
     * @example
     *
     * ```
     *
     * ```
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
        return strval(json_encode($array));
    }

    /**
     * Recursively encode objects in an array as json.
     *
     * @param array<mixed> $array
     *
     * @return array<mixed>
     *
     * @example
     *
     * ```
     *
     * ```
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
            $data[$propertyName] = $propertyValue;

        }
        return strval(
            json_encode(
                [
                    self::CLASS_INDEX =>
                        $objectReflection->type()->__toString(),
                    self::DATA_INDEX =>
                        $data
                ]
            )
        );
    }

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
     * string:
     *
     * ```
     * __class__
     *
     * ```
     *
     * @return void
     *
     * @covers Json::CLASS_INDEX
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
     * string:
     *
     * ```
     * __data__
     *
     * ```
     *
     * @return void
     *
     * @covers Json::DATA_INDEX
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

    protected function randomData(): mixed
    {
        $values = [
            new Id(),
            new Text(new Id()),
            new ClassString(Id::class),
            $this->randomChars(),
            $this->randomClassStringOrObjectInstance(),
            $this->randomFloat(),
            $this->randomObjectInstance(),
            [1, true, false, null, 'string', [], new Text($this->randomChars()), 'baz' => ['secondary_id' => new Id()], 'foo' => 'bar', 'id' => new Id(),],
            true,
            false,
            function (): void {},
            1,
            1.2,
            0,
            [],
            null,
            'foo',
            function (): void {},
            json_encode("Foo bar baz"),
            json_encode($this->randomChars()),
            json_encode(['foo', 'bar', 'baz']),
            json_encode([1, 2, 3]),
            json_encode([PHP_INT_MIN, PHP_INT_MAX]),
            new Directory(),
            new JsonInsance($this->randomClassStringOrObjectInstance()),
            new JsonInsance(json_encode(['foo', 'bar', 'baz'])),
            new Reflection(new ClassString(Id::class)),
            new ReflectionClass($this),
            new ObjectReflection(new Id()),
        ];
        return $values[array_rand($values)];
    }
}

