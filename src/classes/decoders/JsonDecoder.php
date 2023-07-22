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

    private string $dataStringIndex = 'string';
    private string $reflectionClassNamePropertyName  = 'name';

    public function decode(Json $json): mixed
    {
        return $this->decodeJson($json);
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
     * Decode the specified Json.
     *
     * @return mixed
     *
     */
    private function decodeJson(Json $json): mixed
    {
        $data = json_decode($json, true);
        $data = (is_array($data) ? $data : []);
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
                            is_string($originalValue)
                            &&
                            (false !== json_decode($originalValue))
                            &&
                            str_contains($originalValue, Json::CLASS_INDEX)
                            &&
                            str_contains($originalValue, Json::DATA_INDEX)
                        ) {
                            if(
                                is_string($originalValue)
                                &&
                                str_contains(
                                    $originalValue,
                                    strval(json_encode(JsonInstance::class))
                                )
                            ) {
                                $jsonDecodedValue = json_decode(
                                    $originalValue,
                                    true
                                );
                                if(
                                    is_array($jsonDecodedValue)
                                    &&
                                    is_array($jsonDecodedValue[Json::DATA_INDEX])
                                    &&
                                    isset($jsonDecodedValue[Json::DATA_INDEX][$this->dataStringIndex])
                                    &&
                                    is_string($jsonDecodedValue[Json::DATA_INDEX][$this->dataStringIndex])
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
                            $propertyReflection = new ReflectionProperty(
                                $reflectionClass->name,
                                $name
                            );
                            if(
                                !$propertyReflection->isReadOnly()
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
                            } /*else {
                                $this->classDefinesReadOnlyProperties
                                    = match(!is_null($originalValue)) {
                                        true => true,
                                        default => false,
                                    };
                                }*/
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
                $array[$key] = $this->decodeJson($jsonEncodedValue);
            }
        }
        return $array;
    }

}

