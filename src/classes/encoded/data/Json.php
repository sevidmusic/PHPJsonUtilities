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
     * @example
     *
     * ```
     * // Example of encoding an object instance:
     *
     * $objectInstance = new Id();
     *
     * $jsonEncodedObject = new Json($objectInstance);
     *
     * echo $jsonEncodedObject . PHP_EOL;
     *
     * // example output:
     * // {"__class__":"Darling\\PHPTextTypes\\classes\\strings\\Id","__data__":{"text":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\AlphanumericText\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\Text\\\",\\\"__data__\\\":{\\\"string\\\":\\\"QNL3uG13WFlqUzayeUMHAbvamhikpqHCR8dPDDAKv8E1SMi2xx6chWpSwCXclvQIDXKSLg7YuXtUjE\\\"}}\",\"string\":\"QNL3uG13WFlqUzayeUMHAbvamhikpqHCR8dPDDAKv8E1SMi2xx6chWpSwCXclvQIDXKSLg7YuXtUjE\"}}","string":"QNL3uG13WFlqUzayeUMHAbvamhikpqHCR8dPDDAKv8E1SMi2xx6chWpSwCXclvQIDXKSLg7YuXtUjE"}}
     *
     *
     *
     * // Example of encoding an array:
     *
     * $array = [
     *     1,
     *     1.2,
     *     true,
     *     false,
     *     null,
     *     'string',
     *     [],
     *     new Text(str_shuffle('abcdefg')),
     *     'sub_array' => [
     *         'secondary_id' => new Id(),
     *         'sub_sub_array' => [new Id(), [1, 2, 3, [new Id()]], 1.2, []],
     *     ],
     *     'foo' => 'bar',
     *     'id' => new Id(),
     *     'closure' => function(): void {},
     *     'second_sub_array' => [
     *         [[['id' => new Id()], [function(): void {}]], new stdClass()],
     *     ],
     * ];
     *
     * $jsonEncodedArray = new Json($array);
     *
     * echo $jsonEncodedArray . PHP_EOL;
     *
     * // example output:
     * // {"0":1,"1":1.2,"2":true,"3":false,"4":null,"5":"string","6":[],"7":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Text\",\"__data__\":{\"string\":\"abdcefg\"}}","sub_array":{"secondary_id":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"aSo6g3kyO3Blujb9o2RzeUgMvvoFzTq1ZSWrqUsG7f1Hnv9QN8pleCMfjWzZGKXMTXJSI81\\\\\\\"}}\\\",\\\"string\\\":\\\"ASo6g3kyO3Blujb9o2RzeUgMvvoFzTq1ZSWrqUsG7f1Hnv9QN8pleCMfjWzZGKXMTXJSI81\\\"}}\",\"string\":\"ASo6g3kyO3Blujb9o2RzeUgMvvoFzTq1ZSWrqUsG7f1Hnv9QN8pleCMfjWzZGKXMTXJSI81\"}}","sub_sub_array":["{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"R8hVAJLGyIGApgIMShCCxK3U75nHVtO1XTy6ENtuwN9p8Tb3rxWzdXjRgkfImBzpgUfao5vRYBh9MQp2\\\\\\\"}}\\\",\\\"string\\\":\\\"R8hVAJLGyIGApgIMShCCxK3U75nHVtO1XTy6ENtuwN9p8Tb3rxWzdXjRgkfImBzpgUfao5vRYBh9MQp2\\\"}}\",\"string\":\"R8hVAJLGyIGApgIMShCCxK3U75nHVtO1XTy6ENtuwN9p8Tb3rxWzdXjRgkfImBzpgUfao5vRYBh9MQp2\"}}",[1,2,3,["{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"7WjqHKvYxND6YNcEJhondeh5C3BM8k4aKksDf1R7n2JwyExbYh9br6HCCBtl3iPZ0AQbrrTuqgtBlOL\\\\\\\"}}\\\",\\\"string\\\":\\\"7WjqHKvYxND6YNcEJhondeh5C3BM8k4aKksDf1R7n2JwyExbYh9br6HCCBtl3iPZ0AQbrrTuqgtBlOL\\\"}}\",\"string\":\"7WjqHKvYxND6YNcEJhondeh5C3BM8k4aKksDf1R7n2JwyExbYh9br6HCCBtl3iPZ0AQbrrTuqgtBlOL\"}}"]],1.2,[]]},"foo":"bar","id":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"bN3kvpxdR7DvOKvS6TMkqYltL7D0ORTjHaJsOKGJYWnVupuSiiOHXDolIs65UTvk\\\\\\\"}}\\\",\\\"string\\\":\\\"BN3kvpxdR7DvOKvS6TMkqYltL7D0ORTjHaJsOKGJYWnVupuSiiOHXDolIs65UTvk\\\"}}\",\"string\":\"BN3kvpxdR7DvOKvS6TMkqYltL7D0ORTjHaJsOKGJYWnVupuSiiOHXDolIs65UTvk\"}}","closure":"{\"__class__\":\"Closure\",\"__data__\":[]}","second_sub_array":[[[{"id":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"X6ayWvfg6JhYtEoi4dfr0Rjmsjeg7c5eLVXaWrwKbK5HZEysW4bOIBGYywNCmRpTg\\\\\\\"}}\\\",\\\"string\\\":\\\"X6ayWvfg6JhYtEoi4dfr0Rjmsjeg7c5eLVXaWrwKbK5HZEysW4bOIBGYywNCmRpTg\\\"}}\",\"string\":\"X6ayWvfg6JhYtEoi4dfr0Rjmsjeg7c5eLVXaWrwKbK5HZEysW4bOIBGYywNCmRpTg\"}}"},["{\"__class__\":\"Closure\",\"__data__\":[]}"]],"{\"__class__\":\"stdClass\",\"__data__\":[]}"]]}
     *
     *
     *
     * // Example of encoding an valid json string:
     *
     * $jsonString = json_encode([1, [true, false], 'foo' => 'bar']);
     *
     * echo $jsonString . PHP_EOL;
     *
     * // exammple output:
     * // {"0":1,"1":[true,false],"foo":"bar"}
     *
     * $json = new \Darling\PHPJsonUtilities\classes\encoded\data\Json($jsonString);
     *
     * echo $json . PHP_EOL;
     *
     * // example output:
     * // {"0":1,"1":[true,false],"foo":"bar"}
     *
     * ```
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
     * @example
     *
     * ```
     *
     * var_dump($this->encodeMixedValueAsJson('foo');
     *
     * // example output:
     * // string(5) ""foo""
     *
     * ```
     *
     */
    protected function encodeMixedValueAsJson(mixed $data): string
    {
        if(is_object($data)) {
            return $this->encodeObjectAsJson($data);
        }
        return match(gettype($data)) {
            'string' => $this->encodeStringAsJson($data),
            'array' => $this->encodeArrayAsJson($data),
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

}

