<?php

namespace Darling\PHPJsonUtilities\tests\interfaces\encoded\data;

use Darling\PHPJsonUtilities\interfaces\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json as JsonInsance;
use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPTextTypes\classes\strings\ClassString;
use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Darling\PHPTextTypes\classes\strings\Name;
use \Directory;
use \ReflectionClass;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassDefinesReadOnlyProperties;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassA;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassB;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestIterator;

/**
 * The JsonTestTrait defines common tests for implementations of
 * the Json interface.
 *
 * @see Json
 *
 */
trait JsonTestTrait
{

    /**
     * @var Json $json An instance of a Json implementation to test.
     */
    private Json $json;

    private string $expectedJsonString;

    /**
     * Set up an instance of a Json implementation to test.
     *
     * This method must set the expected json string
     * via the setExpectedJsonString() method.
     *
     * This method must also set the Json implementation instance
     * to be tested via the setJsonTestInstance() method.
     *
     * This method may also be used to perform any additional setup
     * required by the implementation being tested.
     *
     * @return void
     *
     * @example
     *
     * ```
     * public function setUp(): void
     * {
     *     $values = [
     *         $this->randomChars(),
     *         $this->randomObjectInstance(),
     *     ];
     *     $data = $values[array_rand($values)];
     *     $this->setExpectedJsonString($data);
     *     $this->setJsonTestInstance(
     *         new JsonInsance($data)
     *     );
     * }
     *
     * ```
     *
     */
    abstract protected function setUp(): void;

    /**
     * Return the Json implementation instance to test.
     *
     * @return Json
     *
     */
    protected function jsonTestInstance(): Json
    {
        return $this->json;
    }

    /**
     * Set the Json implementation instance to test.
     *
     * @param Json $jsonTestInstance An instance of an implementation
     *                               of the Json interface to test.
     *
     * @return void
     *
     */
    protected function setJsonTestInstance(
        Json $jsonTestInstance
    ): void
    {
        $this->json = $jsonTestInstance;
    }

    protected function setExpectedJsonString(mixed $data): void
    {
        $this-> expectedJsonString = $this->encodeMixedValueAsJson(
            $data
        );
    }

    protected function encodeMixedValueAsJson(mixed $data): string
    {
        if(is_object($data)) {
            if(in_array(Json::class, class_implements($data))) {
                /** @var Json $data */
                return $data->__toString();
            }
            return $this->encodeObjectAsJson($data);
        }
        return match(gettype($data)) {
            'string' => $this->encodeStringAsJson($data),
            'array' => $this->encodeArrayAsData($data),
            default => strval(json_encode($data))
        };
    }

    /**
     * Return true if the specified string is a valid json string,
     * false otherwise.
     *
     * @return bool
     *
     * @example
     *
     * ```
     * var_dump($this->stringIsAJsonString(
     * '{"0":1,"1":[true,false],"foo":"bar"}'
     * );
     *
     * // example output
     * // true
     *
     * var_dump($this->stringIsAJsonString('abcdefg');
     *
     * // example output
     * // false
     *
     * ```
     *
     */
    private function stringIsAJsonString(string $string): bool
    {
        return (false !== json_decode($string)) && (json_last_error() === JSON_ERROR_NONE);
    }

    /**
     * Return a json encoded version of specified string.
     *
     * If the string is already valid json string it will
     * be returned unmodified.
     *
     * @return string
     *
     * @example
     *
     * ```
     * var_dump($string);
     *
     * // example output:
     * string(75) "Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\ReflectedSubParentClass"
     *
     * var_dump($this->encodeStringAsJson($string));
     *
     * // example output:
     * string(83) ""Darling\\PHPUnitTestUtilities\\Tests\\dev\\mock\\classes\\ReflectedSubParentClass""
     *
     * var_dump($string);
     *
     * // example output:
     * string(38) "{"__class__":"stdClass","__data__":[]}"
     *
     * var_dump($this->encodeStringAsJson($string));
     *
     * // example output:
     * string(38) "{"__class__":"stdClass","__data__":[]}"
     *
     * ```
     *
     */
    private function encodeStringAsJson(string $string): string
    {
        return match($this->stringIsAJsonString($string)) {
            true => $string,
            default => strval(json_encode($string)),
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
     * @example
     *
     * ```
     * var_dump($array);
     *
     * // example output:
     * array(2) {
     *   [0] =>
     *   array(10) {
     *     [0] =>
     *     int(1)
     *     [1] =>
     *     bool(true)
     *     [2] =>
     *     bool(false)
     *     [3] =>
     *     NULL
     *     [4] =>
     *     string(6) "string"
     *     [5] =>
     *     array(0) {
     *     }
     *     [6] =>
     *     class Darling\PHPTextTypes\classes\strings\Text#359 (1) {
     *       private string $string =>
     *       string(270) "zy@/d@u`^w:y7f5I$|*cg(ha/1Hl
     * AW2=p`^8J9J@_2(</@zWd5g56q#4m+1qۗ4s<p=9Os5Awg#3op4!eWa$*7b%b0x6u^te!imoV=0>y59c^4%im^4&+&j=r^@,kf-;j8h3-)nZimZ4nfT_t"
     *     }
     *     'baz' =>
     *     array(1) {
     *       'secondary_id' =>
     *       class Darling\PHPTextTypes\classes\strings\Id#360 (2) {
     *         ...
     *       }
     *     }
     *     'foo' =>
     *     string(3) "bar"
     *     'id' =>
     *     class Darling\PHPTextTypes\classes\strings\Id#355 (2) {
     *       private string $string =>
     *       string(71) "QLmAr0bji5DOVPLxTUgsm0CV6zBzFFuaZfs9PtbbIZ57cJLV123gwBIGJPK8N6jMXeYi2yO"
     *       private Darling\PHPTextTypes\interfaces\strings\Text $text =>
     *       class Darling\PHPTextTypes\classes\strings\AlphanumericText#356 (2) {
     *         ...
     *       }
     *     }
     *   }
     *
     * var_dump($this->encodeArrayAsJson($array));
     *
     * // example output:
     * string(1547) "{"0":1,"1":true,"2":false,"3":null,"4":"string","5":[],"6":"","baz":{"secondary_id":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\"...
     *
     * ```
     *
     */
    private function encodeArrayAsData(array $array): string
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
        return strval(json_encode($array));
    }

    /**
     * Recursively encode objects in an array as json.
     *
     * @param array<mixed> $array
     *
     * @return array<mixed>
     *
     * @example
     *
     * ```
     * var_dump($array);
     *
     * // example output:
     * array(1) {
     *   'secondary_id' =>
     *   class Darling\PHPTextTypes\classes\strings\Id#360 (2) {
     *     private string $string =>
     *     string(77) "Mz5QlEwix4F56fMRzwDHOJtmBWdNhLN2Ax5XEQ7LBuq8NAKPlmsnwJ1K7l3gPn2ZUwQCIJYFKcckj"
     *     private Darling\PHPTextTypes\interfaces\strings\Text $text =>
     *     class Darling\PHPTextTypes\classes\strings\AlphanumericText#357 (2) {
     *       private string $string =>
     *       string(77) "Mz5QlEwix4F56fMRzwDHOJtmBWdNhLN2Ax5XEQ7LBuq8NAKPlmsnwJ1K7l3gPn2ZUwQCIJYFKcckj"
     *       private Darling\PHPTextTypes\interfaces\strings\Text $text =>
     *       class Darling\PHPTextTypes\classes\strings\Text#358 (1) {
     *         ...
     *       }
     *     }
     *   }
     * }
     *
     * var_dump($this->encodeObjectsInArrayAsJson($array));
     *
     * // example output:
     * array(1) {
     *   'secondary_id' =>
     *   string(595) "{"__class__":"Darling\\PHPTextTypes\\classes\\strings\\Id","__data__":{"text":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\AlphanumericText\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\Text\\\",\\\"__data__\\\":{\\\"string\\\":\\\"Mz5QlEwix4F56fMRzwDHOJtmBWdNhLN2Ax5XEQ7LBuq8NAKPlmsnwJ1K7l3gPn2ZUwQCIJYFKcckj\\\"}}\",\"string\":\"Mz5QlEwix4F56fMRzwDHOJtmBWdNhLN2Ax5XEQ7LBuq8NAKPlmsnwJ1K7l3gPn2ZUwQCIJYFKcckj\"}}","string"...
     * }
     *
     * ```
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
     * @example
     *
     * ```
     * var_dump($object);
     *
     * // example output:
     * class Darling\PHPTextTypes\classes\strings\Id#355 (2) {
     *   private string $string =>
     *   string(64) "1D7uY4fXgU5DM7I9dJ6gqN0FOM9CzImq8K00EAk3zmaLRw9ihCb3Jzsx1yY8oVnB"
     *   private Darling\PHPTextTypes\interfaces\strings\Text $text =>
     *   class Darling\PHPTextTypes\classes\strings\AlphanumericText#356 (2) {
     *     private string $string =>
     *     string(64) "1D7uY4fXgU5DM7I9dJ6gqN0FOM9CzImq8K00EAk3zmaLRw9ihCb3Jzsx1yY8oVnB"
     *     private Darling\PHPTextTypes\interfaces\strings\Text $text =>
     *     class Darling\PHPTextTypes\classes\strings\Text#354 (1) {
     *       private string $string =>
     *       string(64) "1D7uY4fXgU5DM7I9dJ6gqN0FOM9CzImq8K00EAk3zmaLRw9ihCb3Jzsx1yY8oVnB"
     *     }
     *   }
     * }
     *
     * var_dump($this->encodeObjectAsJson($object));
     *
     * // example output:
     * string(556) "{"__class__":"Darling\\PHPTextTypes\\classes\\strings\\Id","__data__":{"text":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\AlphanumericText\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\Text\\\",\\\"__data__\\\":{\\\"string\\\":\\\"1D7uY4fXgU5DM7I9dJ6gqN0FOM9CzImq8K00EAk3zmaLRw9ihCb3Jzsx1yY8oVnB\\\"}}\",\"string\":\"1D7uY4fXgU5DM7I9dJ6gqN0FOM9CzImq8K00EAk3zmaLRw9ihCb3Jzsx1yY8oVnB\"}}","string":"1D7uY4fXgU5DM7I9dJ6gqN0"...
     *
     * ```
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

    /**
     * Return an instance of of an ObjectReflection that reflects
     * the specified $object.
     *
     * @return ObjectReflection
     *
     * @example
     *
     * ```
     * class Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection#63 (2) {
     *   private Darling\PHPTextTypes\classes\strings\ClassString $classString =>
     *   class Darling\PHPTextTypes\classes\strings\ClassString#299 (1) {
     *     private string $string =>
     *     string(41) "Darling\PHPTextTypes\classes\strings\Text"
     *   }
     *   private object $object =>
     *   class Darling\PHPTextTypes\classes\strings\Text#352 (1) {
     *     private string $string =>
     *     string(80) "RoLqEdBZfi8N0lTI6RQHwk5dF6MuMBnTWSJlCm3D6XnVwY8pc2YaEGPx1hjzWTJGSrg9WAd2IAw3iFHZ"
     *   }
     * }
     *
     * ```
     *
     */
    private function objectReflection(
        object $object
    ): ObjectReflection
    {
        return new ObjectReflection($object);
    }

    /**
     * Test that the __toString() method returns the expected json
     * string.
     *
     * @return void
     *
     * @covers \Darling\PHPJsonUtilities\classes\encoded\data\Json::__toString()
     *
     */
    public function test___toString_returns_the_expected_json_string(): void
    {
        $this->assertEquals(
            $this->expectedJsonString,
            $this->jsonTestInstance()->__toString(),
            $this->testFailedMessage(
                $this->jsonTestInstance(),
                '__toString',
                'return the expected json string'
            )
        );
    }

    /**
     * Test that the CLASS_INDEX constant is assigned the
     * string:
     *
     * ```
     * __class__
     *
     * ```
     *
     * @return void
     *
     * @covers Json::CLASS_INDEX
     *
     */
    public function test_CLASS_INDEX_is_assigned_the_string___class__(): void
    {
        $this->assertEquals(
            '__class__',
            $this->jsonTestInstance()::CLASS_INDEX,
            $this->testFailedMessage(
                $this->jsonTestInstance(),
                '',
                'the CLASS_INDEX constant must be assigned the ' .
                'string __class__'
            )
        );
    }

    /**
     * Test that the DATA_INDEX constant is assigned the
     * string:
     *
     * ```
     * __data__
     *
     * ```
     *
     * @return void
     *
     * @covers Json::DATA_INDEX
     *
     */
    public function test_DATA_INDEX_is_assigned_the_string___data__(): void
    {
        $this->assertEquals(
            '__data__',
            $this->jsonTestInstance()::DATA_INDEX,
            $this->testFailedMessage(
                $this->jsonTestInstance(),
                '',
                'the DATA_INDEX constant must be assigned the ' .
                'string __data__'
            )
        );
    }

    protected function randomData(): mixed
    {
        $values = [
            new Id(),
            new Text(new Id()),
            new ClassString(Id::class),
            $this->randomChars(),
            $this->randomClassStringOrObjectInstance(),
            $this->randomFloat(),
            $this->randomObjectInstance(),
            [1, true, false, null, 'string', [], new Text($this->randomChars()), 'baz' => ['secondary_id' => new Id()], 'foo' => 'bar', 'id' => new Id(),],
            true,
            false,
            function (): void {},
            1,
            1.2,
            0,
            [],
            null,
            'foo',
            function (): void {},
            json_encode("Foo bar baz"),
            json_encode($this->randomChars()),
            json_encode(['foo', 'bar', 'baz']),
            json_encode([1, 2, 3]),
            json_encode([PHP_INT_MIN, PHP_INT_MAX]),
            new Directory(),
            new TestClassA(new Id(), new Name(new Text('Foo'))),
            new TestClassB(),
            new TestIterator(),
            new TestClassDefinesReadOnlyProperties('foo'),
            new JsonInsance($this->randomClassStringOrObjectInstance()), // fails
            new JsonInsance(json_encode(['foo', 'bar', 'baz'])), // fails
            new Reflection(new ClassString(Id::class)),
            new ReflectionClass($this),
            new ObjectReflection(new Id()),
        ];
        return $values[array_rand($values)];
    }
}

