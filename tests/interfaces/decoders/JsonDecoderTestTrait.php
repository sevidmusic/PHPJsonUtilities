<?php

namespace Darling\PHPJsonUtilities\tests\interfaces\decoders;

use \Darling\PHPJsonUtilities\classes\encoded\data\Json as JsonInstance;
use \Darling\PHPJsonUtilities\interfaces\decoders\JsonDecoder;
use \Darling\PHPJsonUtilities\interfaces\encoded\data\Json;
use \Darling\PHPMockingUtilities\classes\mock\values\MockClassInstance;
use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPTextTypes\classes\strings\ClassString;
use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\Name;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Darling\PHPTextTypes\classes\strings\UnknownClass;
use \Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\PrivateStaticProperties;
use \Directory;
use \ReflectionClass;
use \ReflectionProperty;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassDefinesReadOnlyProperties;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassA;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassB;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestIterator;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassThatDefinesAPropertyThatAcceptsAJsonInstance;

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
    private string $reflectionClassNamePropertyName  = 'name';

    /**
     * @var JsonDecoder $jsonDecoder An instance of a JsonDecoder
     *                               implementation to test.
     */
    protected JsonDecoder $jsonDecoder;

    private bool $classDefinesReadOnlyProperties = false;

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

    private function JsonInstance(mixed $data): Json
    {
        return new JsonInstance($data);
    }

    private function randomData(): mixed
    {
        $data = [
            $this->randomChars(),
            $this->randomClassStringOrObjectInstance(),
            $this->randomFloat(),
            $this->randomObjectInstance(),
            'foo',
            0,
            1,
            1.2,
            [1, true, false, null, 'string', [], new Text($this->randomChars()), 'baz' => ['secondary_id' => new Id()], 'foo' => 'bar', 'id' => new Id(),],
            [],
            false,
            function (): void {},
            function(): void {},
            json_encode("Foo bar baz"),
            json_encode($this->randomChars()),
            json_encode(['foo', 'bar', 'baz']),
            json_encode([1, 2, 3]),
            json_encode([PHP_INT_MIN, PHP_INT_MAX]),
            new ClassString(Id::class),
            new Directory(),
            new Id(),
            new JsonInstance($this->randomClassStringOrObjectInstance()),
            new JsonInstance(json_encode(['foo', 'bar', 'baz'])),
            new ObjectReflection(new Id()),
            new PrivateStaticProperties(),
            new Reflection(new ClassString(Id::class)),
            new ReflectionClass($this),
            new TestClassA(new Id(), new Name(new Text('Foo'))),
            new TestClassB(),
            new TestClassDefinesReadOnlyProperties('foo'),
            new TestClassThatDefinesAPropertyThatAcceptsAJsonInstance( new JsonInstance(new Id()), new Id(), new Id()),
            new TestIterator(),
            new Text(new Id()),
            new \Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\ReflectedBaseClass(),
            new \Directory(),
            null,
            true,
       ];
        return $data[array_rand($data)];
    }

    private function decodeJson(Json $json): mixed
    {
        $data = $this->decodeToArray($json);
        if(
            isset($data[Json::CLASS_INDEX])
            &&
            is_string($data[Json::CLASS_INDEX])
            &&
            class_exists($data[Json::CLASS_INDEX])
            &&
            isset($data[Json::DATA_INDEX])
            &&
            is_array($data[Json::DATA_INDEX])
        ) {
            $class = $data[Json::CLASS_INDEX];
            if(is_string($class) && class_exists($class)) {
                $reflection = new Reflection(new ClassString($class));
                if($reflection->type()->__toString() === ReflectionClass::class) {
                    $encodedNameProperty = (
                        isset($data[Json::DATA_INDEX][$this->reflectionClassNamePropertyName])
                        &&
                        is_string($data[Json::DATA_INDEX][$this->reflectionClassNamePropertyName])
                        &&
                        class_exists($data[Json::DATA_INDEX][$this->reflectionClassNamePropertyName])
                        ? $data[Json::DATA_INDEX][$this->reflectionClassNamePropertyName]
                        : UnknownClass::class
                    );
                    return new ReflectionClass($encodedNameProperty);
                }
                $mockClassInstance = new MockClassInstance(
                    $reflection
                );
                $object = $mockClassInstance->mockInstance();
                $reflectionClass = new ReflectionClass($object);
                while ($reflectionClass) {
                    foreach (
                        $data[Json::DATA_INDEX]
                        as
                        $name => $originalValue
                    ) {
                        if(
                            $this->valueIsAJsonStringThatContainsJsonEncodedObjectData(
                                $originalValue
                            )
                        ) {
                            if(
                                is_string($originalValue)
                                &&
                                $this->jsonStringIsAnEncodedJsonInstance(
                                    $originalValue
                                )
                            ) {
                                $jsonDecodedValue = json_decode(
                                    $originalValue,
                                    true
                                );
                                if(
                                    is_array($jsonDecodedValue)
                                    &&
                                    $this->arrayContainsJsonEncodedObjectData(
                                        $jsonDecodedValue
                                    )
                                ) {
                                    $originalValue = $this->jsonInstance(
                                        $jsonDecodedValue[Json::DATA_INDEX][$this->dataStringIndex]
                                    );
                                }

                            } else {
                                $originalValue = $this->decodeJson(
                                    $this->jsonInstance($originalValue)
                                );
                            }
                        }
                        if(is_array($originalValue)) {
                            $originalValue = $this->decodeObjectsInArray($originalValue);
                        }
                        if($reflectionClass->hasProperty($name)) {
                            if(
                                $this->propertyIsNotReadOnly(
                                    $name,
                                    $reflectionClass
                                )
                                &&
                                !is_null($originalValue)
                            ) {
                                $acceptedTypes =
                                    $reflection->propertyTypes();
                                $property =
                                    $reflectionClass->getProperty(
                                        $name
                                    );
                                $property->setAccessible(true);
                                $property->setValue(
                                    $object,
                                    $originalValue
                                );
                            } else {
                                $this->classDefinesReadOnlyProperties
                                    = match(!is_null($originalValue)) {
                                        true => true,
                                        default => false,
                                    };
                            }
                        }
                    }
                    $reflectionClass =
                        $reflectionClass->getParentClass();
                    if($reflectionClass !== false) {
                        $reflection = new Reflection(
                            new ClassString(
                                $reflectionClass->getName()
                            )
                        );
                    }
                }
                return $object;
            }
            return new UnknownClass();
        };
        $decodedValue = json_decode($json->__toString(), true);
        if(is_array($decodedValue)) {
            $decodedValue = $this->decodeObjectsInArray(
                $decodedValue
            );
        }
        return $decodedValue;
    }

    /**
     * Determine if a property is defined as readonly.
     *
     * If the property is defined by the class reflected by the
     * specified $reflectionClass, and the property is not defined
     * as readonly, true will be returned.
     *
     * If the property is defined by the class reflected by the
     * specified $reflectionClass, and the property is defined
     * as readonly, false will be returned.
     *
     * If the property is not defined by the class reflected by the
     * specified $reflectionClass, null will be returned.
     *
     * @param $propertyName The name of the property to check.
     *
     * @param ReflectionClass<object> $reflectionClass
     *
     * @return bool
     *
     */
    private function propertyIsNotReadOnly(
        string $propertyName,
        ReflectionClass $reflectionClass
    ): ?bool
    {
        if($reflectionClass->hasProperty($propertyName)) {
            $propertyReflection = new ReflectionProperty(
                $reflectionClass->name,
                $propertyName
            );
            return !$propertyReflection->isReadOnly();
        }
        return null;
    }

    /**
     * Determine if a $value is a json string that contains Json encoded
     * object data.
     *
     * @return bool
     *
     * @example
     *
     * ```
     *
     * ```
     *
     */
    private function valueIsAJsonStringThatContainsJsonEncodedObjectData(
        mixed $originalValue
    ): bool
    {
        return is_string($originalValue)
            &&
            (false !== json_decode($originalValue))
            &&
            str_contains($originalValue, Json::CLASS_INDEX)
            &&
            str_contains($originalValue, Json::DATA_INDEX);
    }

    /**
     * Decode objects that are encoded as Json in the specified array.
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
    private function decodeObjectsInArray(array $array): array
    {
        foreach($array as $key => $value) {
            if(is_array($value)) {
                $array[$key] = $this->decodeObjectsInArray($value);
                continue;
            }

            if(
                is_string($value)
                &&
                str_contains($value, Json::CLASS_INDEX)
                &&
                str_contains($value, Json::DATA_INDEX)
            ) {
                $jsonEncodedValue = new JsonInstance($value);
                $array[$key] = $this->decodeJson($jsonEncodedValue);
            }
        }
        return $array;
    }

    /**
     * [Description]
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
    private function decodeToArray(Json $json): array
    {
        $data = json_decode($json, true);
        return (is_array($data) ? $data : []);
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
        $expectedData = $this->decodeJson($json);
        $decodedData = $this->jsonDecoderTestInstance()->decode($json);
        match(
            is_object($data)
            &&
            is_object($decodedData)
            &&
            $this->classDefinesReadOnlyProperties
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
                    $expectedData,
                    $decodedData,
                    $this->testFailedMessage(
                        $this->jsonDecoderTestInstance(),
                        'decode',
                        'return the original data'
                    ),
                )
        };
    }

    private function objectOrUnknownClass(mixed $value): object
    {
        return match(is_object($value)) {
            true => $value,
            default => new UnknownClass(),
        };
    }

    private function determineClass(mixed $value): ClassString
    {
        return new ClassString($this->objectOrUnknownClass($value));
    }

    private function jsonStringIsAnEncodedJsonInstance(string $vlaue): bool
    {
        return
            str_contains(
                $vlaue,
                strval(json_encode(JsonInstance::class))
            );
    }

    /** @param array<mixed> $array */
    private function arrayContainsJsonEncodedObjectData(array $array): bool
    {
        return
            is_array($array[Json::DATA_INDEX])
            &&
            isset($array[Json::DATA_INDEX][$this->dataStringIndex])
            &&
            is_string($array[Json::DATA_INDEX][$this->dataStringIndex]);
    }
}

