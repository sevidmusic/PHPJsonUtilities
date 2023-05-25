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
     * method will return the original $data.
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
     * ```
     *
     */
    private function stringIsAJsonString(string $string): bool
    {
        return false !== json_decode($string);
    }

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

