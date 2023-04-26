<?php

include('/home/darling/Git/PHPJsonUtilities/vendor/autoload.php');

use \Darling\PHPMockingUtilities\classes\mock\values\MockClassInstance;
use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPReflectionUtilities\interfaces\utilities\Reflection as ReflectionInterface;
use \Darling\PHPTextTypes\classes\strings\AlphanumericText;
use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\Name;
use \Darling\PHPTextTypes\classes\strings\SafeText;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Darling\PHPTextTypes\classes\strings\UnknownClass;
use \Darling\PHPTextTypes\classes\strings\ClassString;
use \Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\PrivateMethods;

/**
 * A Mocker can mock an instance of a class or object instance
 * that is reflected by a Reflection.
 *
 * @example
 *
 * ```
 * $mocker = new Mocker(new ObjectReflection(new stdClass()));
 *
 * $mockInstance = $mocker->mockInstance();
 *
 * var_dump($mockInstance);
 *
 * // example output:
 * class stdClass#38 (0) {
 * }
 *
 * ```
 *
 */
final class Mocker
{
     private const ARRAY = 'array';
     private const BOOLEAN = 'bool';
     private const CONSTRUCT = '__construct';
     private const DOUBLE = 'double';
     private const INTEGER = 'int';
     private const NULL = 'NULL';
     private const STRING = 'string';


     /**
      * Instantiate a new instance of a Mocker.
      *
      * @example
      *
      * ```
      * $mocker = new Mocker(new ObjectReflection(new stdClass()));
      *
      * ```
      *
      * @see \Darling\PHPReflectionUtilities\classes\utilities\Reflection
      * @see https://github.com/sevidmusic/PHPReflectionUtilities/blob/main/src/interfaces/utilities/Reflection.php
      *
      */
     public function __construct(private Reflection $reflection) { }

     /**
      * Return an instance of a ReflectionClass that reflects the
      * specified class or object instance.
      *
      * @param class-string|object $class
      *
      * @return ReflectionClass<object>
      *
      * @example
      *
      * ```
      * var_dump($this->reflectionClass(new stdClass()));
      *
      * // example output:
      * class ReflectionClass#1 (1) {
      *   public string $name =>
      *   string(8) "stdClass"
      * }
      *
      * ```
      * @todo Consider refactoring $class to accept Darling\PHPTextTypes\classes\strings\ClassString once https://github.com/sevidmusic/PHPReflectionUtilities/issues/25 is resolved
      *
      */
     private function reflectionClass(
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
      * Return a mock instance of the same type as the
      * class or object instance reflected by the
      * Reflection assigned to the $reflection property.
      *
      * If supplied, the specified $constructorArguments will
      * be passed to the mock instance's constructor.
      *
      * @param array<mixed> $constructorArguments
      *
      * @return object
      *
      * @example
      *
      * ```
      * $mocker = new Mocker(new ObjectReflection(new stdClass()));
      *
      * $mockInstance = $mocker->mockInstance();
      *
      * var_dump($mockInstance);
      *
      * // example output:
      * class stdClass#38 (0) {
      * }
      *
      * ```
      *
      */
     public function mockInstance(
         array $constructorArguments = []
     ): object
     {
         return $this->getClassInstance(
             $this->reflection->type()->__toString(),
             $constructorArguments
         );
     }

     /**
      * Return a mock instance of the same type as the
      * specified class or object instance.
      *
      * If supplied, the specified $constructorArguments will
      * be passed to the mock instance's constructor.
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
      * $mockInstance = $this->getClassInstance(new stdClass());
      *
      * var_dump($mockInstance);
      *
      * // example output:
      * class stdClass#38 (0) {
      * }
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
      * Generate mock method arguments for the specified method of the
      * provided class or object instance.
      *
      * @param class-string|object $class The class or object instance.
      *
      * @param string $method The name of the method to generate
      *                       arguments for.
      *
      * @return array<mixed>
      *
      * @example
      *
      * ```
      * //
      * var_dump(
      *     $mocker->generateMockClassMethodArguments(
      *         \Darling\PHPTextTypes\classes\strings\Text::class,
      *         '__construct'
      *     )
      * );
      *
      * array(1) {
      *   'string' =>
      *   string(21) "Mocker-DEFAULT_STRING"
      * }
      *
      * ```
      *
      */
    private function generateMockClassMethodArguments(
         string|object $class,
         string $method
    ): array
    {
        $reflection = new Reflection(new ClassString($class));
        $defaultText = new SafeText(new Text(self::class . '-DEFAULT_STRING'));
        $defaults = array();
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
                        $defaults[$name] = $defaultText->__toString();
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
                     * For unknown types check if $type matches an
                     * existing class, if so, assign an instance of
                     * that class.
                     * @var class-string<object> $type
                     */
                    $type = '\\' . str_replace(
                        ['interfaces'],
                        ['classes'],
                        $type
                    );
                    if(class_exists($type)) {
                        $defaults[$name] = $this->getClassInstance(
                            $type
                        );
                    }
                    if(empty($defaults)) {
                        throw new RuntimeException(
                            self::class .
                            ' Error:' .
                            PHP_EOL .
                            'Failed to mock argument ' .
                            $name .
                            ' of type ' .
                            $type .
                            ' for method ' .
                            self::class .
                            '->' .
                            $method
                        );
                    }
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
        if(
            is_object($this->originalValue)
            &&
            in_array(
                Reflector::class,
                class_implements($this->originalValue::class),
            )
        ) {
            throw new RuntimeException(
                self::class .
                ' Error:' .
                PHP_EOL .
                'Cannot use a ' .
                self::class .
                ' to encode an object that ' .
                'is an implementation of a ' .
                Reflector::class
            );
        }

        if(
            is_object($this->originalValue)
            &&
            Closure::class
            ===
            $this->originalValue::class
        ) {
            throw new RuntimeException(
                self::class .
                ' Error:' .
                PHP_EOL .
                'Cannot use a ' .
                self::class .
                ' to encode an object that ' .
                'is an implementation of a ' .
                Closure::class
            );
        }

        if(
            is_object($this->originalValue)
            &&
            in_array(
                ReflectionInterface::class,
                class_implements($this->originalValue::class),
            )
        ) {
            throw new RuntimeException(
                self::class .
                ' Error:' .
                PHP_EOL .
                'Cannot use a ' .
                self::class .
                ' to encode an object that ' .
                'is an implementation of a ' .
                ReflectionInterface::class
            );
        }

        if(
            is_object($this->originalValue)
            &&
            Directory::class === get_class($this->originalValue)
        ) {
            throw new RuntimeException(
                self::class .
                ' Error:' .
                PHP_EOL .
                'Cannot use a ' .
                self::class .
                ' to encode an object that ' .
                'is an implementation of a ' .
                Directory::class
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

final class JsonStringDecoder
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
            $mocker = new MockClassInstance(
                new Reflection(new ClassString($class))
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
            return $object;
        }
        return new UnknownClass();
    }

}

final class TestClassA
{

    public function __construct(private Id $id, private Name $name) {}


        public function id(): Id
        {
            return $this->id;
        }

        public function name(): Name
        {
            return $this->name;
        }

}

final class TestClassB
{

    public string $data = '';

    /**
     * @param array<mixed> $array
     */
    public function __construct(
        private array $array = [],
        private bool $bool = false,
        private float $float = 1.2345,
        private int $int = 12345,
        private string $string = '',
    )
    {
        $this->data = strval(
            json_encode(
                [
                    $this->array,
                    $this->bool,
                    $this->float,
                    $this->int,
                    $this->string
                ]
            )
        );
    }
}

/**
 * @template T
 * @implements Iterator<string>
 */
class TestIterator implements Iterator
{

    /**
     *
     * @param int $position
     * @param array<int, string> $array
     *
     */
    public function __construct(private int $position = 0, private array $array = []) {
        if(empty($this->array)) {
            $this->array = array( "foo", "bar", "baz", "bazzer");
        }
    }

    public function rewind(): void {
        $this->position = 0;
    }

    public function current(): string {
        return $this->array[$this->position];
    }

    public function key(): int {
        return $this->position;
    }

    public function next(): void {
        ++$this->position;
    }

    public function valid(): bool {
        return isset($this->array[$this->position]);
    }
}

$testObjects = [
    new TestClassA(new Id(), new Name(new Text('Name'))),
    new TestIterator(),
    new TestClassB(),
    new AlphanumericText(new Text('AlphanumericText')),
    new Id(),
    new Name(new Text('Name')),
    new SafeText(new Text('SafeText')),
    new Text('Text'),
    new UnknownClass(),
    new PrivateMethods(),
];

$testObject = $testObjects[array_rand($testObjects)];

$testJsonString = new JsonString($testObject);

$jsonStringDecoder = new JsonStringDecoder();

$decodedTestObject = $jsonStringDecoder->decodeJsonToObject(
    $testJsonString
);

$mocker = new MockClassInstance(new ObjectReflection($decodedTestObject));

$mockInstance = $mocker->mockInstance();

var_dump(
    '$decodedTestObject matches $testObject',
    $decodedTestObject == $testObject
);

var_dump(
    '$mockInstance type matches $testObject type',
    $mockInstance::class === $testObject::class
);

file_put_contents(
    '/tmp/darlingTestJson.json',
    PHP_EOL . $testJsonString->__toString()
);


