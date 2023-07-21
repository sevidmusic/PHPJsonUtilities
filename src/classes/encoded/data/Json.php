<?php

namespace Darling\PHPJsonUtilities\classes\encoded\data;

use \Darling\PHPJsonUtilities\interfaces\encoded\data\Json as JsonInterface;
use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;
use \Darling\PHPTextTypes\classes\strings\Text;

class Json extends Text implements JsonInterface
{

    /**
     * Instantiate a Json instance, encoding the specified $data
     * as json.
     *
     * The json encoded $data can be obtained via the __toString()
     * method.
     *
     * @param mixed $data The data to encode as json.
     *
     */
    public function __construct(mixed $data)
    {
        parent::__construct($this->encodeMixedValueAsJson($data));
    }

    /**
     * Encode a value of any type as json.
     *
     * @return string
     *
     */
    protected function encodeMixedValueAsJson(mixed $data): string
    {
        return match(gettype($data)) {
            'object' => $this->encodeObjectAsJson($data),
            'array' => $this->encodeArrayAsJson($data),
            default => strval($this->jsonEncode($data)),
        };
    }

    /**
     * Recursively encode an array as json.
     *
     * Objects in the array will also be properly encoded as json.
     *
     * @param array<mixed> $array
     *
     * @return string
     *
     */
    private function encodeArrayAsJson(array $array): string
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
     * Recursively encode objects in the specified array as json,
     * and return the modified array.
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
     * Encode an object as json, including it's property data.
     *
     * @return string
     *
     */
    private function encodeObjectAsJson(object $object): string
    {
        $propertyData = [];
        $objectReflection = $this->objectReflection($object);
        foreach($objectReflection->propertyValues() as $propertyName => $propertyValue)
        {
            if(is_object($propertyValue)) {
                $propertyData[$propertyName] = $this->encodeObjectAsJson(
                    $propertyValue
                );
               continue;
            }
            if(is_array($propertyValue)) {
                $propertyValue = $this->encodeObjectsInArrayAsJson($propertyValue);
            }
            $propertyData[$propertyName] = $propertyValue;

        }
        return $this->jsonEncode(
            [
                self::CLASS_INDEX =>
                    $objectReflection->type()->__toString(),
                self::DATA_INDEX => $propertyData
            ]
        );
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
     * Encode the specified $data as json.
     *
     * @return string
     *
     */
    private function jsonEncode(mixed $data): string
    {
        return strval(json_encode($data, JSON_PRESERVE_ZERO_FRACTION, 2147483647));
    }

}

