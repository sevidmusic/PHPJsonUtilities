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

class JsonDecoder implements JsonDecoderInterface
{

    public function decode(Json $json): mixed
    {
        if($this->isAJsonEncodedObjectInstance($json)) {
            return $this->decodeJsonEncodedObject($json);
        };
        $decodedValue = $this->decodeJsonEncodedValue($json);
        if(is_array($decodedValue)) {
            $decodedValue = $this->decodeObjectsInArray(
                $decodedValue
            );
        }
        return $decodedValue;
    }

    /**
     * Determine if the specified Json is a json encoded object
     * instance.
     *
     * @param Json $json The Json instance to check.
     *
     * @return bool
     *
     * @example
     *
     * ```
     * var_dump($jsonEncodedString);
     *
     * // example output:
     * class Darling\PHPJsonUtilities\classes\encoded\data\Json#3 (1) {
     *   private string $string =>
     *   string(5) ""foo""
     * }
     *
     * var_dump($this->isAJsonEncodedObjectInstance($jsonEncodedString));
     *
     * // example output:
     * bool(false)
     *
     * var_dump($jsonEncodedObjectInstance);
     *
     * // example output:
     * class Darling\PHPJsonUtilities\classes\encoded\data\Json#2 (1) {
     *   private string $string =>
     *   string(574) "{"__class__":"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id","__data__":{"text":"{\\"__class__\\":\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\",\\"__data__\\":{\\"text\\":\\"{\\\\\\"__class__\\\\\\":\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\",\\\\\\"__data__\\\\\\":{\\\\\\"string\\\\\\":\\\\\\"PrMi9mQ5mBn0Tc3JJafsxbWTIKi7mLujs6afzzGZ1DktMbpH2V5tE4BxoOAB2RqXwCh7gS\\\\\\"}}\\",\\"string\\":\"...
     * }
     *
     * var_dump($this->isAJsonEncodedObjectInstance($jsonEncodedObjectInstance));
     *
     * // example output:
     * bool(true)
     *
     * ```
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
     * @example
     *
     * ```
     * php > var_dump($json);
     *
     * // example output:
     * class Darling\PHPJsonUtilities\classes\encoded\data\Json#3 (1) {
     *   private string $string =>
     *   string(586) "{"__class__":"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id","__data__":{"text":"{\\"__class__\\":\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\",\\"__data__\\":{\\"text\\":\\"{\\\\\\"__class__\\\\\\":\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\",\\\\\\"__data__\\\\\\":{\\\\\\"string\\\\\\":\\\\\\"vYPoXMWAL8sSw5TkIfnx4G5M4jhScZgWwIQPQyC2aVJRco0Esigi1WU6tfr3Oa8DOyUD9VhD7H\\\\\\"}}\\",\\"string\"...
     * }
     *
     * var_dump($this->decodeJsonEncodedObject($json));
     *
     * // example output:
     * class Darling\PHPTextTypes\classes\strings\Id#9 (2) {
     *   private string $string =>
     *   string(74) "VYPoXMWAL8sSw5TkIfnx4G5M4jhScZgWwIQPQyC2aVJRco0Esigi1WU6tfr3Oa8DOyUD9VhD7H"
     *   private Darling\PHPTextTypes\interfaces\strings\Text $text =>
     *   class Darling\PHPTextTypes\classes\strings\AlphanumericText#12 (2) {
     *     private string $string =>
     *     string(74) "VYPoXMWAL8sSw5TkIfnx4G5M4jhScZgWwIQPQyC2aVJRco0Esigi1WU6tfr3Oa8DOyUD9VhD7H"
     *     private Darling\PHPTextTypes\interfaces\strings\Text $text =>
     *     class Darling\PHPTextTypes\classes\strings\Text#18 (1) {
     *       private string $string =>
     *       string(74) "vYPoXMWAL8sSw5TkIfnx4G5M4jhScZgWwIQPQyC2aVJRco0Esigi1WU6tfr3Oa8DOyUD9VhD7H"
     *     }
     *   }
     * }
     *
     * ```
     *
     */
    private function decodeJsonEncodedObject(Json $json): object
    {
        $reflection = $this->reflectJsonEncodedObject($json);
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
                    $propertyValue = $this->decode(
                        $this->encodeValueAsJson($propertyValue)
                    );
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
     * Decode the specified $json and return an array of property data
     * if it exists, otherwise return an empty array.
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
    private function propertyDataOrEmptyArray(Json $json): array
    {
        $encodedData = $this->decodeJsonToArray($json);
        return match(is_array($encodedData[Json::DATA_INDEX])) {
            true => $encodedData[Json::DATA_INDEX],
            default => [],
        };
    }
    /**
     * Set the value of the specified property via reflection.
     *
     * @param ReflectionClass<object> $reflectionClass
     *
     * @example
     *
     * ```
     *
     * ```
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
            if(!is_null($propertyValue)) {
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
     * Decode the specified $json and return the original value.
     *
     * @return mixed
     *
     * @example
     *
     * ```
     * var_dump($this->decodeJsonEncodedValue(new Json('foo')));
     *
     * // example output
     * string(3) "foo"
     *
     * ```
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
            if($this->valueIsAJsonStringThatContainsJsonEncodedObjectData($value)) {
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
     * @example
     *
     * ```
     * var_dump($json->__toString());
     *
     * // example output
     * string(136) "{"__class__":"Darling\\PHPTextTypes\\classes\\strings\\ClassString","__data__":{"string":"Darling\\PHPTextTypes\\classes\\strings\\Id"}}"
     *
     * var_dump($this->decodeJsonToArray($json));
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
     * @example
     *
     * ```
     *
     * ```
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
     * @example
     *
     * ```
     *
     * ```
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
     * @example
     *
     * ```
     *
     * ```
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
     * @example
     *
     * ```
     *
     * ```
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
     * @example
     *
     * ```
     *
     * ```
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
     * @example
     *
     * ```
     *
     * ```
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
     * @example
     *
     * ```
     *
     * ```
     *
     */
    private function isAValidJsonString(string $string): bool
    {
        return (false !== json_decode($string));
    }
}

