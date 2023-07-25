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

#    private string $dataStringIndex = 'string';
    private string $reflectionClassNamePropertyName  = 'name';

    public function decode(Json $json): mixed
    {
        $data = $this->jsonDecode($json->__toString());
        if(!is_array($data) && !is_object($data)) {
            return $data;
        }
        if(
            is_array($data)
            &&
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
            $propertyData = $data[Json::DATA_INDEX];
            if($class === ReflectionClass::class) {
                $encodedNameProperty = (
                    isset($propertyData[$this->reflectionClassNamePropertyName])
                    &&
                    is_string($propertyData[$this->reflectionClassNamePropertyName])
                    &&
                    class_exists($propertyData[$this->reflectionClassNamePropertyName])
                    ? $propertyData[$this->reflectionClassNamePropertyName]
                    : UnknownClass::class
                );
                return new ReflectionClass($encodedNameProperty);
            }
            $reflection = new Reflection(new ClassString($class));
            $mockClassInstance = new MockClassInstance(
                $reflection
            );
            $object = $mockClassInstance->mockInstance();
            $reflectionClass = new ReflectionClass($object);
            while ($reflectionClass) {
                foreach (
                    $propertyData
                    as
                    $propertyName => $propertyValue
                ) {
                    if(is_array($propertyValue)) {
                        $propertyValue = $this->decodeObjectsInArray($propertyValue);
                    }
                    if(
                        is_string($propertyValue)
                        &&
                        (false !== $this->jsonDecode($propertyValue))
                        &&
                        str_contains($propertyValue, Json::CLASS_INDEX)
                        &&
                        str_contains($propertyValue, Json::DATA_INDEX)
                    ) {
                        $propertyValue = $this->decode(
                            $this->jsonInstance($propertyValue)
                        );
                    }
                    if($reflectionClass->hasProperty($propertyName)) {
                        $propertyReflection = new ReflectionProperty(
                            $reflectionClass->name,
                            $propertyName
                        );
                        if(
                            !$propertyReflection->isReadOnly()
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
                $reflectionClass =
                    $reflectionClass->getParentClass();
                if($reflectionClass !== false) {
                    $reflection = new Reflection(
                        new ClassString(
                            $reflectionClass->getName()
                        )
                    );
                }
            } // end while
            return $object;
        };
        $decodedValue = $this->jsonDecode($json->__toString());
        if(is_array($decodedValue)) {
            $decodedValue = $this->decodeObjectsInArray(
                $decodedValue
            );
        }
        return $decodedValue;
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
     * Decode objects that are encoded as Json in the specified array.
     *
     * @param array<mixed> $array
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
            if(
                is_string($value)
                &&
                str_contains($value, Json::CLASS_INDEX)
                &&
                str_contains($value, Json::DATA_INDEX)
            ) {
                $jsonEncodedValue = new JsonInstance($value);
                $array[$key] = $this->decode($jsonEncodedValue);
            }
        }
        return $array;
    }

    private function jsonDecode(string $jsonString): mixed
    {
        return json_decode($jsonString, true, 2147483647, JSON_PRESERVE_ZERO_FRACTION);
    }
}

