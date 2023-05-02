<?php

namespace Darling\PHPJsonUtilities\classes\encoded\data;

use Darling\PHPJsonUtilities\interfaces\encoded\data\Json as JsonInterface;
use \Darling\PHPMockingUtilities\classes\mock\values\MockClassInstance;
use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPReflectionUtilities\interfaces\utilities\Reflection as ReflectionInterface;
use \Darling\PHPTextTypes\classes\strings\AlphanumericText;
use \Darling\PHPTextTypes\classes\strings\ClassString;
use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\Name;
use \Darling\PHPTextTypes\classes\strings\SafeText;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Darling\PHPTextTypes\classes\strings\UnknownClass;
use \Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\PrivateMethods;

class Json extends Text implements JsonInterface
{

    /**
     * Instantiate a Json instance using the specified $data,
     * encoding the data as json if possible.
     *
     * The json can be obtained via the __toString() method.
     *
     * If the specified $data is is already a valid json string,
     * then the $data will not be encoded, i.e., the __toString()
     * method will return the original $data.
     *
     * @example
     *
     * ```
     * $json = new \Darling\PHPJsonUtilities\classes\encoded\data\Json(
     *     'some data'
     * );
     *
     * ```
     *
     */
    public function __construct(mixed $data)
    {
        parent::__construct($this->encodeAsJson($data));
    }

    private function encodeAsJson(mixed $data): string
    {
        return match(is_object($data)) {
            true => $this->encodeObjectAsJson($data),
            default => $this->encodeValueAsJson($data),
        };
    }

    protected function encodeValueAsJson(mixed $data): string
    {
        return strval(
            is_string($data)
            &&
            false !== json_decode($data)
            ? $data
            : json_encode($data)
        );
    }

    private function encodeObjectAsJson(object $object): string
    {
        $data = [];
        $objectReflection = $this->objectReflection($object);
        foreach(
            $objectReflection->propertyValues()
            as
            $propertyName => $propertyValue
        )
        {
            if(is_object($propertyValue)) {
                $data[$propertyName] = $this->encodeObjectAsJson(
                    $propertyValue
                );
               continue;
            }
            $data[$propertyName] = $propertyValue;

        }
        return strval(
            json_encode(
                [
                    self::CLASS_INDEX =>
                        $objectReflection->type()->__toString(),
                    self::DATA_INDEX =>
                        $data
                ]
            )
        );
    }

    private function objectReflection(
        object $object
    ): ObjectReflection
    {
        return new ObjectReflection($object);
    }

}

