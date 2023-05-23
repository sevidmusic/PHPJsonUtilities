```
   ___  __ _____     __              __  ____  _ ___ __  _
  / _ \/ // / _ \__ / /__ ___  ___  / / / / /_(_) (_) /_(_)__ ___
 / ___/ _  / ___/ // (_-</ _ \/ _ \/ /_/ / __/ / / / __/ / -_|_-<
/_/  /_//_/_/   \___/___/\___/_//_/\____/\__/_/_/_/\__/_/\__/___/


             A library for working with json in php


         https://github.com/sevidmusic/PHPJsonUtilities
```

The PHPJsonUtilities library provides classes for working with
`JSON` in php.

The following classes are provided by this library:

```
\Darling\PHPJsonUtilities\classes\encoded\data\Json

```
Which is a `\Stringable` type that can be used to encode values of
various types as valid `JSON`.

```
\Darling\PHPJsonUtilities\classes\decoders\JsonDecoder

```

Which provides a `decode()` method that can be used
to decode values that were encoded as `JSON` via a
`\Darling\PHPJsonUtilities\classes\encoded\data\Json`
instance.

# Overview

- [Installation](#installation)
- [Examples](#examples)
    1. [Json](#darlingphpjsonutilitiesclassesencodeddatajson)
    2. [JsonDecoder](#darlingphpjsonutilitiesclassesdecodersjsondecoder)

# Installation

```
composer require darling/php-json-utilities

```

# Examples

### `\Darling\PHPJsonUtilities\classes\encoded\data\Json`

A `\Darling\PHPJsonUtilities\classes\encoded\data\Json` instance can
be used to encode values of various types as `JSON`.

Any value that can be encoded as `JSON` via `json_encode()`
can be encoded as `JSON` via a
`\Darling\PHPJsonUtilities\classes\encoded\data\Json` instance.

However, unlike `json_encode()`, objects encoded as `JSON` via a
`\Darling\PHPJsonUtilities\classes\encoded\data\Json` instance
will have their property values preserved.

Note:
At the moment objects that are values of an array are not
properly encoded. This issue is being addressed.

@see [Issue #34](https://github.com/sevidmusic/PHPJsonUtilities/issues/34)
@see [Issue #35](https://github.com/sevidmusic/PHPJsonUtilities/issues/35)

Example:

```
<?php

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

$objectInstance = new Id();

$jsonEncodedObject = new Json($objectInstance);

echo $jsonEncodedObject . PHP_EOL;

/**
 * example output:
 * {"__class__":"Darling\\PHPTextTypes\\classes\\strings\\Id","__data__":{"text":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\AlphanumericText\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\Text\\\",\\\"__data__\\\":{\\\"string\\\":\\\"QNL3uG13WFlqUzayeUMHAbvamhikpqHCR8dPDDAKv8E1SMi2xx6chWpSwCXclvQIDXKSLg7YuXtUjE\\\"}}\",\"string\":\"QNL3uG13WFlqUzayeUMHAbvamhikpqHCR8dPDDAKv8E1SMi2xx6chWpSwCXclvQIDXKSLg7YuXtUjE\"}}","string":"QNL3uG13WFlqUzayeUMHAbvamhikpqHCR8dPDDAKv8E1SMi2xx6chWpSwCXclvQIDXKSLg7YuXtUjE"}}
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
 * {"0":1,"1":1.2,"2":true,"3":false,"4":null,"5":"string","6":[],"7":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Text\",\"__data__\":{\"string\":\"abdcefg\"}}","sub_array":{"secondary_id":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"aSo6g3kyO3Blujb9o2RzeUgMvvoFzTq1ZSWrqUsG7f1Hnv9QN8pleCMfjWzZGKXMTXJSI81\\\\\\\"}}\\\",\\\"string\\\":\\\"ASo6g3kyO3Blujb9o2RzeUgMvvoFzTq1ZSWrqUsG7f1Hnv9QN8pleCMfjWzZGKXMTXJSI81\\\"}}\",\"string\":\"ASo6g3kyO3Blujb9o2RzeUgMvvoFzTq1ZSWrqUsG7f1Hnv9QN8pleCMfjWzZGKXMTXJSI81\"}}","sub_sub_array":["{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"R8hVAJLGyIGApgIMShCCxK3U75nHVtO1XTy6ENtuwN9p8Tb3rxWzdXjRgkfImBzpgUfao5vRYBh9MQp2\\\\\\\"}}\\\",\\\"string\\\":\\\"R8hVAJLGyIGApgIMShCCxK3U75nHVtO1XTy6ENtuwN9p8Tb3rxWzdXjRgkfImBzpgUfao5vRYBh9MQp2\\\"}}\",\"string\":\"R8hVAJLGyIGApgIMShCCxK3U75nHVtO1XTy6ENtuwN9p8Tb3rxWzdXjRgkfImBzpgUfao5vRYBh9MQp2\"}}",[1,2,3,["{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"7WjqHKvYxND6YNcEJhondeh5C3BM8k4aKksDf1R7n2JwyExbYh9br6HCCBtl3iPZ0AQbrrTuqgtBlOL\\\\\\\"}}\\\",\\\"string\\\":\\\"7WjqHKvYxND6YNcEJhondeh5C3BM8k4aKksDf1R7n2JwyExbYh9br6HCCBtl3iPZ0AQbrrTuqgtBlOL\\\"}}\",\"string\":\"7WjqHKvYxND6YNcEJhondeh5C3BM8k4aKksDf1R7n2JwyExbYh9br6HCCBtl3iPZ0AQbrrTuqgtBlOL\"}}"]],1.2,[]]},"foo":"bar","id":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"bN3kvpxdR7DvOKvS6TMkqYltL7D0ORTjHaJsOKGJYWnVupuSiiOHXDolIs65UTvk\\\\\\\"}}\\\",\\\"string\\\":\\\"BN3kvpxdR7DvOKvS6TMkqYltL7D0ORTjHaJsOKGJYWnVupuSiiOHXDolIs65UTvk\\\"}}\",\"string\":\"BN3kvpxdR7DvOKvS6TMkqYltL7D0ORTjHaJsOKGJYWnVupuSiiOHXDolIs65UTvk\"}}","closure":"{\"__class__\":\"Closure\",\"__data__\":[]}","second_sub_array":[[[{"id":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"X6ayWvfg6JhYtEoi4dfr0Rjmsjeg7c5eLVXaWrwKbK5HZEysW4bOIBGYywNCmRpTg\\\\\\\"}}\\\",\\\"string\\\":\\\"X6ayWvfg6JhYtEoi4dfr0Rjmsjeg7c5eLVXaWrwKbK5HZEysW4bOIBGYywNCmRpTg\\\"}}\",\"string\":\"X6ayWvfg6JhYtEoi4dfr0Rjmsjeg7c5eLVXaWrwKbK5HZEysW4bOIBGYywNCmRpTg\"}}"},["{\"__class__\":\"Closure\",\"__data__\":[]}"]],"{\"__class__\":\"stdClass\",\"__data__\":[]}"]]}
 */


```

### `\Darling\PHPJsonUtilities\classes\decoders\JsonDecoder`

A `\Darling\PHPJsonUtilities\classes\decoders\JsonDecoder` can
be used to decode values that were encoded as `JSON` via a
`\Darling\PHPJsonUtilities\classes\encoded\data\Json` instance.

Note:
At the moment objects that are values of an array are not
properly decoded. This is being addressed.

@see https://github.com/sevidmusic/PHPJsonUtilities/issues/34
@see https://github.com/sevidmusic/PHPJsonUtilities/issues/35

Example:

```
<?php

require_once(
    __DIR__ .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\Text;

$jsonDecoder = new JsonDecoder();

$objectInstance = new Id();

$jsonEncodedObject = new Json($objectInstance);

$decodedObject = $jsonDecoder->decode($jsonEncodedObject);

var_dump($decodedObject);

/**
 * example output:
 * class Darling\PHPTextTypes\classes\strings\Id#9 (2) {
 *   private string $string =>
 *   string(74) "Zz7SsSjwk1XAyOwIfaJpJkQ7tCWmRxBEql5P8WXFB1rKE9TqWYvgs6A5VbnZ8GioHNFAwhvjKd"
 *   private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *   class Darling\PHPTextTypes\classes\strings\AlphanumericText#17 (2) {
 *     private string $string =>
 *     string(74) "Zz7SsSjwk1XAyOwIfaJpJkQ7tCWmRxBEql5P8WXFB1rKE9TqWYvgs6A5VbnZ8GioHNFAwhvjKd"
 *     private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *     class Darling\PHPTextTypes\classes\strings\Text#18 (1) {
 *       private string $string =>
 *       string(74) "zz7SsSjwk1XAyOwIfaJpJkQ7tCWmRxBEql5P8WXFB1rKE9TqWYvgs6A5VbnZ8GioHNFAwhvjKd"
 *     }
 *   }
 * }
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

$decodedArray = $jsonDecoder->decode($jsonEncodedArray);

var_dump($decodedArray);

/**
 * example output:
 * array(13) {
 *   [0] =>
 *   int(1)
 *   [1] =>
 *   double(1.2)
 *   [2] =>
 *   bool(true)
 *   [3] =>
 *   bool(false)
 *   [4] =>
 *   NULL
 *   [5] =>
 *   string(6) "string"
 *   [6] =>
 *   array(0) {
 *   }
 *   [7] =>
 *   class Darling\PHPTextTypes\classes\strings\Text#31 (1) {
 *     private string $string =>
 *     string(7) "efdgcab"
 *   }
 *   'sub_array' =>
 *   array(2) {
 *     'secondary_id' =>
 *     class Darling\PHPTextTypes\classes\strings\Id#23 (2) {
 *       private string $string =>
 *       string(64) "CoSksBkY7Gc5sAwAliSnqoLIBUnPdMFjmOap7fzJbfh6mbhD6Z8erjEYLrsQ3PNZ"
 *       private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *       class Darling\PHPTextTypes\classes\strings\AlphanumericText#43 (2) {
 *         ...
 *       }
 *     }
 *     'sub_sub_array' =>
 *     array(4) {
 *       [0] =>
 *       class Darling\PHPTextTypes\classes\strings\Id#38 (2) {
 *         ...
 *       }
 *       [1] =>
 *       array(4) {
 *         ...
 *       }
 *       [2] =>
 *       double(1.2)
 *       [3] =>
 *       array(0) {
 *         ...
 *       }
 *     }
 *   }
 *   'foo' =>
 *   string(3) "bar"
 *   'id' =>
 *   class Darling\PHPTextTypes\classes\strings\Id#19 (2) {
 *     private string $string =>
 *     string(71) "8auyxWPvjHED83bZLfjDEw1kYMQ59n5820TsrRlr9P57pvgMGmpU4gPZL04BdBf9mHAyqne"
 *     private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *     class Darling\PHPTextTypes\classes\strings\AlphanumericText#69 (2) {
 *       private string $string =>
 *       string(71) "8auyxWPvjHED83bZLfjDEw1kYMQ59n5820TsrRlr9P57pvgMGmpU4gPZL04BdBf9mHAyqne"
 *       private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *       class Darling\PHPTextTypes\classes\strings\Text#56 (1) {
 *         ...
 *       }
 *     }
 *   }
 *   'closure' =>
 *   class Closure#54 (1) {
 *       virtual $closure =>
 *       "$this->Darling\PHPMockingUtilities\classes\mock\values\{closure}"
 *     public $this =>
 *     class Darling\PHPMockingUtilities\classes\mock\values\MockClosure#46 (0) {
 *     }
 *   }
 *   'second_sub_array' =>
 *   array(1) {
 *     [0] =>
 *     array(2) {
 *       [0] =>
 *       array(2) {
 *         ...
 *       }
 *       [1] =>
 *       class stdClass#66 (0) {
 *         ...
 *       }
 *     }
 *   }
 * }
 */

```

