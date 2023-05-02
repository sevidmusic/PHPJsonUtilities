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
        return match(
            str_contains($json->__toString(), Json::CLASS_INDEX)
            &&
            str_contains($json->__toString(), Json::DATA_INDEX)
        ) {
            true => $this->decodeJsonToObject($json),
            default => json_decode($json->__toString()),
        };
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
            $mocker = new MockClassInstance(
                new Reflection(new ClassString($class))
            );
            $object = $mocker->mockInstance();
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
}

