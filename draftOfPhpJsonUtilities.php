<?php

include('/home/darling/Git/PHPJsonUtilities/vendor/autoload.php');

use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPTextTypes\classes\strings\AlphanumericText;
use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\Name;
use \Darling\PHPTextTypes\classes\strings\SafeText;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Darling\PHPTextTypes\classes\strings\UnknownClass;
use \Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\PrivateMethods;

/**
 * This class will not  be apart of this library, it will be
 * apart of astandalone library that will be required by this library.
 *
 * Drafting it here in order to draft this library's classes.
 *
 */
class Mocker
{
     private const ARRAY = 'array';
     private const BOOLEAN = 'bool';
     private const CONSTRUCT = '__construct';
     private const DOUBLE = 'double';
     private const INTEGER = 'integer';
     private const NULL = 'NULL';
     private const STRING = 'string';


     public function __construct(private Reflection $reflection) { }

     private function reflection(): Reflection
     {
         return $this->reflection;
     }

     /**
      * [Description]
      *
      * @param class-string|object $class
      *
      * @return ReflectionClass<object>
      *
      * @example
      *
      * ```
      *
      * ```
      *
      */
     public function reflectionClass(
         string|object $class
     ): ReflectionClass
    {
        if(
            class_exists(
                (
                    is_object($class)
                    ? $class::class
                    : $class
                )
            )
        ) {
            return new ReflectionClass($class);
        }
        return new ReflectionClass(new UnknownClass());
    }


     /**
      * [Description]
      *
      * @param array<mixed> $constructorArguments
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
     public function mockInstance(
         array $constructorArguments = []
     ): object
     {
         return $this->getClassInstance(
             $this->reflection()->type()->__toString(),
             $constructorArguments
         );
     }

    /**
     * [Description]
     *
     * @param class-string|object $class
     *
     * @param array<mixed> $constructorArguments
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
     private function getClassInstance(
         string|object $class,
         array $constructorArguments = []
     ): object
     {
        if (method_exists($class, self::CONSTRUCT) === false) {
            try {
                return $this->reflectionClass($class)
                            ->newInstanceArgs([]);
            } catch (ReflectionException $e) {
                return $e;
            }
        }
        if (empty($constructorArguments) === true) {
            try {
                return $this->reflectionClass($class)
                            ->newInstanceArgs(
                                $this->generateMockClassMethodArguments(
                                    $class,
                                    self::CONSTRUCT
                                )
                );
            } catch (ReflectionException $e) {
                return $e;
            }
        }
        return $this->reflectionClass($class)->newInstanceArgs(
            $constructorArguments
        );
    }

     /**
      * [Description]
      *
      * @param class-string|object $class
      *
      * @param string $method
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
     private function generateMockClassMethodArguments(
         string|object $class,
         string $method
     ): array
    {
        $reflection = new Reflection($this->reflectionClass($class));
        $defaults = array();
        $id = new Id();
        $randChars = $id->__toString();
        if(method_exists($class, $method)) {
            foreach (
                $reflection->methodParameterTypes($method)
                as
                $name => $types
            ) {
                foreach($types as $type) {
                    if ($type === self::BOOLEAN) {
                        $defaults[$name] = false;
                        continue;
                    }
                    if ($type === self::INTEGER) {
                        $defaults[$name] = 1;
                        continue;
                    }
                    if ($type === self::DOUBLE) {
                        $defaults[$name] = 1.2345;
                        continue;
                    }
                    if ($type === self::STRING) {
                        $defaults[$name] = $randChars;
                        continue;
                    }
                    if ($type === self::ARRAY) {
                        $defaults[$name] = [];
                        continue;
                    }
                    if ($type === self::NULL) {
                        $defaults[$name] = null;
                        continue;
                    }
                    /**
                     * For unknown types assume class instance.
                     * @var class-string<object>|object $type
                     */
                    $type = '\\' . str_replace(
                        ['interfaces'],
                        ['classes'],
                        $type
                    );
                    $defaults[$name] = $this->getClassInstance(
                        $type
                    );
                }
            }
        }
        return $defaults;
    }

}

final class JsonString extends Text
{

    public const CLASS_INDEX = '__class__';
    public const DATA_INDEX = '__data__';

    public function __construct(
        private mixed $originalValue,
        private bool $originalValueIsJson = false
    ) {
        $this->verifyOriginalValueCanBeEncoded();
        match(is_object($this->originalValue)) {
            true => parent::__construct(
                $this->encodeObjectAsJson($this->originalValue)
            ),
            default => parent::__construct($this->encodeOriginalValueAsJson())
        };
    }

    private function verifyOriginalValueCanBeEncoded(): void
    {
        if(
            is_object($this->originalValue)
            &&
            $this->originalValue::class === self::class
        ) {
            throw new RuntimeException(
                self::class .
                ' Error:' .
                PHP_EOL .
                'Cannot use a ' .
                self::class .
                ' to encode another ' .
                self::class
            );
        }
    }

    protected function encodeOriginalValueAsJson(): string
    {
        return strval(
            is_string($this->originalValue)
            &&
            $this->originalValueIsJson === true
            &&
            false !== json_decode($this->originalValue)
            ? $this->originalValue
            : json_encode($this->originalValue)
        );
    }

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

class JsonStringDecoder
{

    public function decodeJsonToObject(JsonString $json): object {
        $data = json_decode($json, true);
        if (
            is_array($data)
            &&
            isset($data[JsonString::CLASS_INDEX])
            &&
            isset($data[JsonString::DATA_INDEX])
        ) {
            $class = $data[JsonString::CLASS_INDEX];
            $mocker = new Mocker(
                new Reflection(new ReflectionClass($class))
            );
            $object = $mocker->mockInstance();
            $reflection = new ReflectionClass($object);
            while ($reflection) {
                foreach (
                    $data[JsonString::DATA_INDEX]
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
                                JsonString::CLASS_INDEX
                            )
                            &&
                            str_contains(
                                $originalValue,
                                JsonString::DATA_INDEX
                            )
                        ) {
                            $originalValue = $this->decodeJsonToObject(
                                new JsonString($originalValue, true)
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
              if($object::class === JsonString::class) {
                  /**
                   * @var JsonString $object
                   * @todo
                   * This is a hack, need to figure this out better
                   */
                  $object->__toString();
              }

            return $object;
        }
        return new UnknownClass();
    }

}

$jsonStringDecoder = new JsonStringDecoder();

$testObjects = [
    new JsonString(new JsonString(new Id())), // FAILS : Solution: Do not allow JsonStrings to represent/encode other JsonStrings
#    new AlphanumericText(new Text('AlphanumericText')),
#    new Id(),
#    new Name(new Text('Name')),
#    new SafeText(new Text('SafeText')),
#    new Text('Text'),
#    new UnknownClass(),
#    new PrivateMethods(),
];

$testObject = $testObjects[array_rand($testObjects)];

$testJsonString = new JsonString($testObject);

$decodedTestObject = $jsonStringDecoder->decodeJsonToObject(
    $testJsonString
);
var_dump(
    '$decodedTestObject matches $testObject',
    $decodedTestObject == $testObject
);

/*
// save json for later viewing/debugging
file_put_contents(
    '/tmp/darlingTestJson.json',
    $testJsonString->__toString()
);
*/
