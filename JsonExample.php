<?php

/**
 * This file provides examples that demonstrate how to use a Json
 * instance to encode values as json.
 */

require_once(
    __DIR__ .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\Text;

/**
 * Example of encoding an object:
 */
$objectInstance = new Id();

$jsonEncodedObject = new Json($objectInstance);

echo $jsonEncodedObject . PHP_EOL;

/**
 * example output:
 *
 * {"__class__":"Darling\\PHPTextTypes\\classes\\strings\\Id","__data__":{"text":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\AlphanumericText\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\Text\\\",\\\"__data__\\\":{\\\"string\\\":\\\"QNL3uG13WFlqUzayeUMHAbvamhikpqHCR8dPDDAKv8E1SMi2xx6chWpSwCXclvQIDXKSLg7YuXtUjE\\\"}}\",\"string\":\"QNL3uG13WFlqUzayeUMHAbvamhikpqHCR8dPDDAKv8E1SMi2xx6chWpSwCXclvQIDXKSLg7YuXtUjE\"}}","string":"QNL3uG13WFlqUzayeUMHAbvamhikpqHCR8dPDDAKv8E1SMi2xx6chWpSwCXclvQIDXKSLg7YuXtUjE"}}
 *
 */

/**
 * Example of encoding an array:
 */
$array = [
    1,
    1.2,
    true,
    false,
    null,
    'string',
    [],
    new Text(str_shuffle('abcdefg')),
    'sub_array' => [
        'secondary_id' => new Id(),
        'sub_sub_array' => [new Id(), [1, 2, 3, [new Id()]], 1.2, []],
    ],
    'foo' => 'bar',
    'id' => new Id(),
    'closure' => function(): void {},
    'second_sub_array' => [
        [[['id' => new Id()], [function(): void {}]], new stdClass()],
    ],
];

$jsonEncodedArray = new Json($array);

echo $jsonEncodedArray . PHP_EOL;

/**
 * example output:
 *
 * {"0":1,"1":1.2,"2":true,"3":false,"4":null,"5":"string","6":[],"7":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Text\",\"__data__\":{\"string\":\"abdcefg\"}}","sub_array":{"secondary_id":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"aSo6g3kyO3Blujb9o2RzeUgMvvoFzTq1ZSWrqUsG7f1Hnv9QN8pleCMfjWzZGKXMTXJSI81\\\\\\\"}}\\\",\\\"string\\\":\\\"ASo6g3kyO3Blujb9o2RzeUgMvvoFzTq1ZSWrqUsG7f1Hnv9QN8pleCMfjWzZGKXMTXJSI81\\\"}}\",\"string\":\"ASo6g3kyO3Blujb9o2RzeUgMvvoFzTq1ZSWrqUsG7f1Hnv9QN8pleCMfjWzZGKXMTXJSI81\"}}","sub_sub_array":["{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"R8hVAJLGyIGApgIMShCCxK3U75nHVtO1XTy6ENtuwN9p8Tb3rxWzdXjRgkfImBzpgUfao5vRYBh9MQp2\\\\\\\"}}\\\",\\\"string\\\":\\\"R8hVAJLGyIGApgIMShCCxK3U75nHVtO1XTy6ENtuwN9p8Tb3rxWzdXjRgkfImBzpgUfao5vRYBh9MQp2\\\"}}\",\"string\":\"R8hVAJLGyIGApgIMShCCxK3U75nHVtO1XTy6ENtuwN9p8Tb3rxWzdXjRgkfImBzpgUfao5vRYBh9MQp2\"}}",[1,2,3,["{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"7WjqHKvYxND6YNcEJhondeh5C3BM8k4aKksDf1R7n2JwyExbYh9br6HCCBtl3iPZ0AQbrrTuqgtBlOL\\\\\\\"}}\\\",\\\"string\\\":\\\"7WjqHKvYxND6YNcEJhondeh5C3BM8k4aKksDf1R7n2JwyExbYh9br6HCCBtl3iPZ0AQbrrTuqgtBlOL\\\"}}\",\"string\":\"7WjqHKvYxND6YNcEJhondeh5C3BM8k4aKksDf1R7n2JwyExbYh9br6HCCBtl3iPZ0AQbrrTuqgtBlOL\"}}"]],1.2,[]]},"foo":"bar","id":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"bN3kvpxdR7DvOKvS6TMkqYltL7D0ORTjHaJsOKGJYWnVupuSiiOHXDolIs65UTvk\\\\\\\"}}\\\",\\\"string\\\":\\\"BN3kvpxdR7DvOKvS6TMkqYltL7D0ORTjHaJsOKGJYWnVupuSiiOHXDolIs65UTvk\\\"}}\",\"string\":\"BN3kvpxdR7DvOKvS6TMkqYltL7D0ORTjHaJsOKGJYWnVupuSiiOHXDolIs65UTvk\"}}","closure":"{\"__class__\":\"Closure\",\"__data__\":[]}","second_sub_array":[[[{"id":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"X6ayWvfg6JhYtEoi4dfr0Rjmsjeg7c5eLVXaWrwKbK5HZEysW4bOIBGYywNCmRpTg\\\\\\\"}}\\\",\\\"string\\\":\\\"X6ayWvfg6JhYtEoi4dfr0Rjmsjeg7c5eLVXaWrwKbK5HZEysW4bOIBGYywNCmRpTg\\\"}}\",\"string\":\"X6ayWvfg6JhYtEoi4dfr0Rjmsjeg7c5eLVXaWrwKbK5HZEysW4bOIBGYywNCmRpTg\"}}"},["{\"__class__\":\"Closure\",\"__data__\":[]}"]],"{\"__class__\":\"stdClass\",\"__data__\":[]}"]]}
 *
 */

/**
 * Example of encoding an valid json string:
 * (if a string is a valid json string no further encoding will occur)
 */
$jsonString = json_encode([1, [true, false], 'foo' => 'bar']);

echo $jsonString . PHP_EOL;

// exammple output:
// {"0":1,"1":[true,false],"foo":"bar"}

$json = new \Darling\PHPJsonUtilities\classes\encoded\data\Json($jsonString);

echo $json . PHP_EOL;

// example output:
// {"0":1,"1":[true,false],"foo":"bar"}

