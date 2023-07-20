<?php

namespace Darling\PHPJsonUtilities\classes\encoded\data;

use Darling\PHPJsonUtilities\interfaces\encoded\data\Json as JsonInterface;
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
     * If the specified $data is is already a valid json string,
     * then the $data will not be encoded, i.e., the __toString()
     * method will return the $data unmodified.
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
        if(is_object($data)) {
            return $this->encodeObjectAsJson($data);
        }
        return match(gettype($data)) {
            'array' => $this->encodeArrayAsJson($data),
            default => strval($this->jsonEncode($data))
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
     * Recursively encode objects in an array as json.
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
     * Encode an object as json.
     *
     * @return string
     *
     */
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
            if(is_array($propertyValue)) {
                $propertyValue = $this->encodeObjectsInArrayAsJson($propertyValue);
            }
            $data[$propertyName] = $propertyValue;

        }
        return strval(
            $this->jsonEncode(
                [
                    self::CLASS_INDEX =>
                        $objectReflection->type()->__toString(),
                    self::DATA_INDEX =>
                        $data
                ]
            )
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

