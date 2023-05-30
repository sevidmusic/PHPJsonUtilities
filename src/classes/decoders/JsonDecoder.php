<?php

namespace Darling\PHPJsonUtilities\classes\decoders;

use Darling\PHPJsonUtilities\interfaces\decoders\JsonDecoder as JsonDecoderInterface;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json as JsonInstance;
use \Darling\PHPJsonUtilities\interfaces\encoded\data\Json;
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
                $reflection = new Reflection(
                    new ClassString($class)
                );
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
                            if(!is_null($originalValue)) {
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
     * Decode objects that are encoded as Json in the specified array.
     *
     * @param array<mixed> $array The array.
     *
     * @return array<mixed>
     *
     * @example
     *
     * ```
     * var_dump($array);
     *
     * // example output
     * array(10) {
     *   [0] =>
     *   int(1)
     *   [1] =>
     *   bool(true)
     *   [2] =>
     *   bool(false)
     *   [3] =>
     *   NULL
     *   [4] =>
     *   string(6) "string"
     *   [5] =>
     *   array(0) {
     *   }
     *   [6] =>
     *   string(0) ""
     *   'baz' =>
     *   array(1) {
     *     'secondary_id' =>
     *     string(577) "{"__class__":"Darling\\PHPTextTypes\\classes\\strings\\Id","__data__":{"text":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\AlphanumericText\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\Text\\\",\\\"__data__\\\":{\\\"string\\\":\\\"OyndS4bdpKqBJFwtm6HzF4CT1DEFL1Ir6ncvpvOtJPYxgMzIeqZkfTUSOG1b3j7Wh6j1Rrr\\\"}}\",\"string\":\"OyndS4bdpKqBJFwtm6HzF4CT1DEFL1Ir6ncvpvOtJPYxgMzIeqZkfTUSOG1b3j7Wh6j1Rrr\"}}","string":"OyndS4bdp"...
     *   }
     *   'foo' =>
     *   string(3) "bar"
     *   'id' =>
     *   string(559) "{"__class__":"Darling\\PHPTextTypes\\classes\\strings\\Id","__data__":{"text":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\AlphanumericText\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\Text\\\",\\\"__data__\\\":{\\\"string\\\":\\\"72Kc6xsMT8aLRqOIimMV1cE3yAbSGpNPW5dsKgc1B4OrTDf9XRaHqmDYzuX36F5W2\\\"}}\",\"string\":\"72Kc6xsMT8aLRqOIimMV1cE3yAbSGpNPW5dsKgc1B4OrTDf9XRaHqmDYzuX36F5W2\"}}","string":"72Kc6xsMT8aLRqOIimMV1"...
     * }
     *
     * var_dump($this->decodeObjectsInArray($array));
     *
     * // example output
     * array(10) {
     *   [0] =>
     *   int(1)
     *   [1] =>
     *   bool(true)
     *   [2] =>
     *   bool(false)
     *   [3] =>
     *   NULL
     *   [4] =>
     *   string(6) "string"
     *   [5] =>
     *   array(0) {
     *   }
     *   [6] =>
     *   string(0) ""
     *   'baz' =>
     *   array(1) {
     *     'secondary_id' =>
     *     class Darling\PHPTextTypes\classes\strings\Id#262 (2) {
     *       private string $string =>
     *       string(71) "OyndS4bdpKqBJFwtm6HzF4CT1DEFL1Ir6ncvpvOtJPYxgMzIeqZkfTUSOG1b3j7Wh6j1Rrr"
     *       private Darling\PHPTextTypes\interfaces\strings\Text $text =>
     *       class Darling\PHPTextTypes\classes\strings\AlphanumericText#257 (2) {
     *         ...
     *       }
     *     }
     *   }
     *   'foo' =>
     *   string(3) "bar"
     *   'id' =>
     *   class Darling\PHPTextTypes\classes\strings\Id#276 (2) {
     *     private string $string =>
     *     string(65) "72Kc6xsMT8aLRqOIimMV1cE3yAbSGpNPW5dsKgc1B4OrTDf9XRaHqmDYzuX36F5W2"
     *     private Darling\PHPTextTypes\interfaces\strings\Text $text =>
     *     class Darling\PHPTextTypes\classes\strings\AlphanumericText#254 (2) {
     *       private string $string =>
     *       string(65) "72Kc6xsMT8aLRqOIimMV1cE3yAbSGpNPW5dsKgc1B4OrTDf9XRaHqmDYzuX36F5W2"
     *       private Darling\PHPTextTypes\interfaces\strings\Text $text =>
     *       class Darling\PHPTextTypes\classes\strings\Text#271 (1) {
     *         ...
     *       }
     *     }
     *   }
     * }
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

            if(is_string($value) && str_contains($value, Json::CLASS_INDEX) && str_contains($value, Json::DATA_INDEX)) {
                $jsonEncodedValue = new JsonInstance($value);
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
     * @example
     *
     * ```
     * var_dump($json->__toString());
     *
     * // example output
     * string(136) "{"__class__":"Darling\\PHPTextTypes\\classes\\strings\\ClassString","__data__":{"string":"Darling\\PHPTextTypes\\classes\\strings\\Id"}}"
     *
     * var_dump($this->decodeToArray($json));
     *
     * // example output
     * array(2) {
     *   '__class__' =>
     *   string(48) "Darling\PHPTextTypes\classes\strings\ClassString"
     *   '__data__' =>
     *   array(1) {
     *     'string' =>
     *     string(39) "Darling\PHPTextTypes\classes\strings\Id"
     *   }
     * }
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

