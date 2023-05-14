<?php

namespace Darling\PHPJsonUtilities\classes\decoders;

use Darling\PHPJsonUtilities\interfaces\decoders\JsonDecoder as JsonDecoderInterface;
use \Darling\PHPJsonUtilities\interfaces\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json as JsonInstance;
use \Darling\PHPMockingUtilities\classes\mock\values\MockClassInstance;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPTextTypes\classes\strings\ClassString;
use \Darling\PHPTextTypes\classes\strings\UnknownClass;
use \ReflectionClass;

class JsonDecoder implements JsonDecoderInterface
{

    public function decode(Json $json): mixed
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
                $mockClassInstance = new MockClassInstance($reflection);
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
                                $originalValue = $this->decode(
                                    new JsonInstance($originalValue)
                                );
                            }
                        }
                        if($reflectionClass->hasProperty($name)) {
                            // possible fix: check if original property is null and if property in mock is uninitialized
                            if(!is_null($originalValue)) {
                                $acceptedTypes = $reflection->propertyTypes();
                                $property = $reflectionClass->getProperty($name);
                                $property->setAccessible(true);
                                $property->setValue($object, $originalValue);
                            }
                        }
                    }
                    $reflectionClass = $reflectionClass->getParentClass();
                    if($reflectionClass !== false) {
                        $reflection = new Reflection(new ClassString($reflectionClass->getName()));
                    }
                }
                return $object;
            }
            return new UnknownClass();
        };
        return json_decode($json->__toString());
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
}

