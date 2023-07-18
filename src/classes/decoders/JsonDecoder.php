<?php

namespace Darling\PHPJsonUtilities\classes\decoders;

use \Darling\PHPJsonUtilities\classes\encoded\data\Json as JsonInstance;
use \Darling\PHPJsonUtilities\interfaces\decoders\JsonDecoder as JsonDecoderInterface;
use \Darling\PHPJsonUtilities\interfaces\encoded\data\Json;
use \Darling\PHPMockingUtilities\classes\mock\values\MockClassInstance;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPTextTypes\classes\strings\ClassString;
use \Darling\PHPTextTypes\classes\strings\UnknownClass;
use \ReflectionClass;
use \ReflectionProperty;

class JsonDecoder implements JsonDecoderInterface
{

    private const DATA_STRING_INDEX = 'string';
    private const REFLECTION_CLASS_NAME_PROPERTY_NAME = 'name';

    public function decode(Json $json): mixed
    {
        return json_decode($json->__toString(), true, 2147483647, JSON_PRESERVE_ZERO_FRACTION);
    }

    /**
     * Determine if the specified Json is a json encoded object
     * instance.
     *
     * @param Json $json The Json instance to check.
     *
     * @return bool
     *
     */
    private function isAJsonEncodedObjectInstance(Json $json): bool
    {
        $data = $this->decodeJsonToArray($json);
        return
            isset($data[Json::CLASS_INDEX])
            &&
            is_string($data[Json::CLASS_INDEX])
            &&
            class_exists($data[Json::CLASS_INDEX])
            &&
            isset($data[Json::DATA_INDEX])
            &&
            is_array($data[Json::DATA_INDEX]);
    }

    /**
     * Decode the specified $json. If the decoded value is an
     * object instance, return it, otherwise return an instance
     * of an UnknownClass.
     *
     * @return object
     *
     */
    private function decodeJsonEncodedObject(Json $json): object
    {
        $reflection = $this->reflectJsonEncodedObject($json);
        if($reflection->type()->__toString() === ReflectionClass::class) {
            $data = $this->decodeJsonToArray($json);
            $encodedNameProperty = (
                is_array($data[Json::DATA_INDEX])
                &&
                isset($data[Json::DATA_INDEX][self::REFLECTION_CLASS_NAME_PROPERTY_NAME])
                &&
                is_string($data[Json::DATA_INDEX][self::REFLECTION_CLASS_NAME_PROPERTY_NAME])
                &&
                class_exists($data[Json::DATA_INDEX][self::REFLECTION_CLASS_NAME_PROPERTY_NAME])
                ? $data[Json::DATA_INDEX][self::REFLECTION_CLASS_NAME_PROPERTY_NAME]
                : UnknownClass::class
            );
            return new ReflectionClass($encodedNameProperty);
        }
        $decodedObject = $this->mockInstanceOfReflectedClass(
            $reflection
        );
        $reflectionClass = $reflection->reflectionClass();
        while($reflectionClass) {
            foreach (
                $this->propertyDataOrEmptyArray($json)
                as
                $propertyName => $propertyValue
            ) {
                if(
                    $this->valueIsAJsonStringThatContainsJsonEncodedObjectData(
                        $propertyValue
                    )
                ) {
                    if(
                        is_string($propertyValue)
                        &&
                        $this->jsonStringIsAnEncodedJsonInstance(
                            $propertyValue
                        )
                    ) {
                        $jsonDecodedValue = json_decode(
                            $propertyValue,
                            true
                        );
                        if(
                            is_array($jsonDecodedValue)
                            &&
                            $this->arrayContainsJsonEncodedObjectData(
                                $jsonDecodedValue
                            )
                        ) {
                            $propertyValue = $this->encodeValueAsJson(
                                $jsonDecodedValue[Json::DATA_INDEX][self::DATA_STRING_INDEX]
                            );
                        }

                    } else {
                        $propertyValue = $this->decode(
                            $this->encodeValueAsJson($propertyValue)
                        );
                    }
                }
                if(is_array($propertyValue)) {
                    $propertyValue = $this->decodeObjectsInArray($propertyValue);
                }
                $this->assignNewPropertyValue(
                    $propertyName,
                    $propertyValue,
                    $decodedObject,
                    $reflection,
                    $reflectionClass
                );
            }
            $reflectionClass = $reflectionClass->getParentClass();
            if($reflectionClass !== false) {
                $reflection = new Reflection(
                    new ClassString(
                        $reflectionClass->getName()
                    )
                );
            }
        }
        return $decodedObject;
    }

    /**
     * If the specified $json is an json encoded object instance,
     * return an array of the encoded objects property data,
     * otherwise return an empty array.
     *
     * @return array<mixed>
     *
     */
    private function propertyDataOrEmptyArray(Json $json): array
    {
        $encodedData = $this->decodeJsonToArray($json);
        if(
            isset($encodedData[Json::DATA_INDEX])
            &&
            is_array($encodedData[Json::DATA_INDEX])
        ) {
            return $encodedData[Json::DATA_INDEX];
        }
        return [];
    }

    /**
     * Set the value of the specified property via reflection.
     *
     * @param ReflectionClass<object> $reflectionClass
     *
     */
    private function assignNewPropertyValue(
        string $propertyName,
        mixed $propertyValue,
        object $object,
        Reflection $reflection,
        ReflectionClass $reflectionClass
    ): void
    {
        if($reflectionClass->hasProperty($propertyName)) {
            if(
                $this->propertyIsNotReadOnly(
                    $propertyName,
                    $reflectionClass
                )
                &&
                !is_null($propertyValue)
            ) {
                $acceptedTypes =
                    $reflection->propertyTypes();
                $property =
                    $reflectionClass->getProperty(
                        $propertyName
                    );
                $property->setAccessible(true);
                $property->setValue(
                    $object,
                    $propertyValue
                );
            }
        }
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
     * Decode the specified $json and return the original value.
     *
     * @return mixed
     *
     */
    private function decodeJsonEncodedValue(Json $json): mixed
    {
        return json_decode($json->__toString(), true);
    }

    /**
     * Decode objects that are encoded as Json in the specified array.
     *
     * @param array<mixed> $array The array.
     *
     * @return array<mixed>
     *
     */
    private function decodeObjectsInArray(array $array): array
    {
        foreach($array as $key => $value) {
            if(is_array($value)) {
                $array[$key] = $this->decodeObjectsInArray($value);
                continue;
            }
            if($this->valueIsAJsonStringThatContainsJsonEncodedObjectData(
                $value)
            ) {
                $jsonEncodedValue = $this->encodeValueAsJson($value);
                $array[$key] = $this->decode($jsonEncodedValue);
            }
        }
        return $array;
    }

    /**
     * Decode the specified Json to an array.
     *
     * If the Json cannot be decoded to an array, then an
     * empty array will be returned.
     *
     * @return array<mixed>
     *
     */
    private function decodeJsonToArray(Json $json): array
    {
        $data = $this->decodeJsonEncodedValue($json);
        return (is_array($data) ? $data : []);
    }

    /**
     * Instantiate a new Json instance for the specified value.
     *
     * @return Json
     *
     */
    private function encodeValueAsJson(mixed $value): Json
    {
        return new JsonInstance($value);
    }

    /**
     * Determine if a $value is a json string that contains Json encoded
     * object data.
     *
     * @return bool
     *
     */
    private function valueIsAJsonStringThatContainsJsonEncodedObjectData(
        mixed $value
    ): bool
    {
        return is_string($value)
            && $this->isAValidJsonString($value)
            && $this->stringContainsClassAndDataIndex($value);
    }

    /**
     * If the specified $json is a json encoded object, return an
     * instance of a ClassString for the encoded object, otherwise
     * return an instance of a ClassString for an UnknownClass.
     *
     * @param Json $json
     *
     * @return ClassString
     *
     */
    private function determineClass(Json $json): ClassString
    {
        $data = $this->decodeJsonToArray($json);
        $class = $data[Json::CLASS_INDEX] ?? '';
        if(is_string($class)) {
            return new ClassString($class);
        }
        return new ClassString(UnknownClass::class);
    }

    /**
     * Mock an instance of the same type as the class reflected by the
     * provided $reflection.
     *
     * @param Reflection $reflection
     *
     * @return object
     *
     */
    private function mockInstanceOfReflectedClass(
        Reflection $reflection
    ): object
    {
        $mockClassInstance = new MockClassInstance($reflection);
        return $mockClassInstance->mockInstance();
    }

    /**
     * Return an instance of a Reflection that reflects the type
     * of object encoded in the specified $json.
     *
     * Note: An instance of a Reflection that reflects an UnknownClass
     * will be returned if the provided $json is not a json encoded
     * object, or if the original objects class cannot be determined
     * from the provided $json.
     *
     * @return Reflection
     *
     */
    private function reflectJsonEncodedObject(Json $json): Reflection
    {
        return new Reflection($this->determineClass($json));
    }

    /**
     * Return true if a string contains the expected Json::CLASS_INDEX
     * and Json::DATA_INDEX strings, false otherwise.
     *
     * @return bool
     *
     */
    private function stringContainsClassAndDataIndex(
        string $string
    ): bool
    {
        return str_contains($string, Json::CLASS_INDEX)
            && str_contains($string, Json::DATA_INDEX);
    }

    /**
     * Determine if a string is a valid json string.
     *
     * @return bool
     *
     */
    private function isAValidJsonString(string $string): bool
    {
        return (false !== json_decode($string));
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
            isset($array[Json::DATA_INDEX][self::DATA_STRING_INDEX])
            &&
            is_string($array[Json::DATA_INDEX][self::DATA_STRING_INDEX]);
    }
}

