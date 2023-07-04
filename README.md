```
   ___  __ _____     __              __  ____  _ ___ __  _
  / _ \/ // / _ \__ / /__ ___  ___  / / / / /_(_) (_) /_(_)__ ___
 / ___/ _  / ___/ // (_-</ _ \/ _ \/ /_/ / __/ / / / __/ / -_|_-<
/_/  /_//_/_/   \___/___/\___/_//_/\____/\__/_/_/_/\__/_/\__/___/


             A library for working with json in php


         https://github.com/sevidmusic/PHPJsonUtilities

```

The PHPJsonUtilities library provides classes for working with
`json` in php.

The following classes are provided by this library:

```
\Darling\PHPJsonUtilities\classes\encoded\data\Json
```

Which is a `\Stringable` type that can be used to encode values of
various types as valid `json`.

```
\Darling\PHPJsonUtilities\classes\decoders\JsonDecoder
```

Which provides a `decode()` method that can be used
to decode values that were encoded as `json` via a
`\Darling\PHPJsonUtilities\classes\encoded\data\Json`
instance.

# Overview

- [Installation](#installation)

- [Json](#json)
    1. [Encoding an Object instance](#encoding-an-object-instance)
    2. [Encoding an Object instance that defines readonly properties](#encoding-an-object-instance-that-defines-readonly-properties)
    3. [Encoding a string](#encoding-a-string)
    4. [Encoding an int](#encoding-an-int)
    5. [Encoding a float](#encoding-a-float)
    6. [Encoding a bool](#encoding-a-bool)
    7. [Encoding an array](#encoding-an-array)
    8. [Encoding an Iterator](#encoding-an-iterator)
    9. [Encoding a Closure](#encoding-a-closure)
    10. [Encoding a valid json string](#encoding-a-valid-json-string)
    11. [Encoding a Darling\PHPJsonUtilities\classes\encoded\data\Json instance](#encoding-a-darlingphpjsonutilitiesclassesencodeddatajson-instance)

- [JsonDecoder](#jsondecoder)
    1. [Encoding and decoding an Object instance](#encoding-and-decoding-an-object-instance)
    2. [Encoding and decoding an Object instance that defines readonly properties](#encoding-and-decoding-an-object-instance-that-defines-readonly-properties)
    3. [Encoding and decoding a string](#encoding-and-decoding-a-string)
    4. [Encoding and decoding an int](#encoding-and-decoding-an-int)
    5. [Encoding and decoding a float](#encoding-and-decoding-a-float)
    6. [Encoding and decoding a bool](#encoding-and-decoding-a-bool)
    7. [Encoding and decoding an array](#encoding-and-decoding-an-array)
    8. [Encoding and decoding an Iterator](#encoding-and-decoding-an-iterator)
    9. [Encoding and decoding a Closure](#encoding-and-decoding-a-closure)
    10. [Encoding and decoding a valid json string](#encoding-and-decoding-a-valid-json-string)
    11. [Encoding and decoding a Darling\PHPJsonUtilities\classes\encoded\data\Json instance](#encoding-and-decoding-a-darlingphpjsonutilitiesclassesencodeddatajson-instance)

# Installation

```
composer require darling/php-json-utilities
```

# Json

A `\Darling\PHPJsonUtilities\classes\encoded\data\Json` instance can
be used to encode values of various types as valid `json`.

Any value that can be encoded as `json` via `json_encode()`
can be encoded as `json` via a
`\Darling\PHPJsonUtilities\classes\encoded\data\Json` instance.

However, unlike `json_encode()`, objects encoded as `json` via a
`\Darling\PHPJsonUtilities\classes\encoded\data\Json` instance
will have their type and property values preserved.

Examples:

### Encoding an Object instance

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode an
 * object instance as json.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAnObjectInstance.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPTextTypes\classes\strings\Id;

$objectInstance = new Id();

$jsonEncodedObject = new Json($objectInstance);

echo $jsonEncodedObject . PHP_EOL;

/**
 * example output:
 *
 * {"__class__":"Darling\\PHPTextTypes\\classes\\strings\\Id","__data__":{"text":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\AlphanumericText\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\Text\\\",\\\"__data__\\\":{\\\"string\\\":\\\"e7HyfqWD8p2NeU8TLXUJEtEjxIJlSx3HqgrrMhxIkYXyYLhSifrmGR7K3QGkrJ1lAo6Iuw40lwFj\\\"}}\",\"string\":\"E7HyfqWD8p2NeU8TLXUJEtEjxIJlSx3HqgrrMhxIkYXyYLhSifrmGR7K3QGkrJ1lAo6Iuw40lwFj\"}}","string":"E7HyfqWD8p2NeU8TLXUJEtEjxIJlSx3HqgrrMhxIkYXyYLhSifrmGR7K3QGkrJ1lAo6Iuw40lwFj"}}
 *
 */

```

### Encoding an Object instance that defines readonly properties

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode an
 * object instance that defines readonly properties as json.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAnObjectInstanceThatDefinesReadonlyProperties.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;

class DefinesReadonlyProperties
{

    public function __construct(private readonly int $int) {}

    public function getInt(): int
    {
        return $this->int;
    }
}

$objectInstance = new DefinesReadonlyProperties(10);

$jsonEncodedObject = new Json($objectInstance);

echo $jsonEncodedObject . PHP_EOL;

/**
 * example output:
 *
 * {"__class__":"DefinesReadonlyProperties","__data__":{"int":10}}
 *
 */

```

### Encoding a string

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a string as json.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAString.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPMockingUtilities\classes\mock\values\MockString;

$string = new MockString();

$jsonEncodedString = new Json($string->value());

echo $jsonEncodedString . PHP_EOL;

/**
 * example output:
 *
 * "MockString6SWnnT5kaibcMMIjjFsqasQ7vfjwyfKlpqiVNEJ"
 *
 */

```

### Encoding an int

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a int as json.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAnInt.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPMockingUtilities\classes\mock\values\MockInt;

$int = new MockInt();

$jsonEncodedInt = new Json($int->value());

echo $jsonEncodedInt . PHP_EOL;

/**
 * example output:
 *
 * 2609743170528575717
 *
 */

```

### Encoding a float

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a float as json.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAFloat.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPMockingUtilities\classes\mock\values\MockFloat;

$float = new MockFloat();

$jsonEncodedFloat = new Json($float->value());

echo $jsonEncodedFloat . PHP_EOL;

/**
 * example output:
 *
 * 2716017.3333333335
 *
 */

```

### Encoding a bool

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a bool as json.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingABool.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPMockingUtilities\classes\mock\values\MockBool;

$bool = new MockBool();

$jsonEncodedBool = new Json($bool->value());

echo $jsonEncodedBool . PHP_EOL;

/**
 * example output:
 *
 * false
 *
 */

```

### Encoding an array

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a array as json.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAnArray.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPMockingUtilities\classes\mock\values\MockBool;
use \Darling\PHPMockingUtilities\classes\mock\values\MockClosure;
use \Darling\PHPMockingUtilities\classes\mock\values\MockFloat;
use \Darling\PHPMockingUtilities\classes\mock\values\MockInt;
use \Darling\PHPMockingUtilities\classes\mock\values\MockMixedValue;
use \Darling\PHPMockingUtilities\classes\mock\values\MockString;
use \Darling\PHPTextTypes\classes\strings\Id;

$bool = new MockBool();
$closure = new MockClosure();
$float = new MockFloat();
$int = new MockInt();
$mixed = new MockMixedValue();
$string = new MockString();

 * Note: Nested objects and arrays will also be properly encoded.
 *
 */
$array = [
    $bool->value(),
    $closure->value(),
    $float->value(),
    $int->value(),
    $mixed->value(),
    $string->value(),
    'nested-array' => [
        [
            new Id(),
            new Id(),
            new Id(),
        ]
    ]
];
$jsonEncodedArray = new Json($array);

echo $jsonEncodedArray . PHP_EOL;

/**
 * example output:
 *
 * {"0":false,"1":"{\"__class__\":\"Closure\",\"__data__\":[]}","2":549409.875,"3":-6064629463085977541,"4":true,"5":"MockStringLCQeRy6euDGKpPETYHCJzfzWZo3tCOAq4lkrtp7","nested-array":[["{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"VEQ9qiC72OaZRAHtpZHCb2An7cdwQI8xi1331UmK3F1uYFV5NkDfv8jRSO8MIZMN6P6quYokyBmv\\\\\\\"}}\\\",\\\"string\\\":\\\"VEQ9qiC72OaZRAHtpZHCb2An7cdwQI8xi1331UmK3F1uYFV5NkDfv8jRSO8MIZMN6P6quYokyBmv\\\"}}\",\"string\":\"VEQ9qiC72OaZRAHtpZHCb2An7cdwQI8xi1331UmK3F1uYFV5NkDfv8jRSO8MIZMN6P6quYokyBmv\"}}","{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"S7yzDlx4A4a9p1xY6LEPQeu3HO0wAkM6OtToFnFURjlFDaKIeuHsHbNIt6RsxuZqcg9ZBNmym2\\\\\\\"}}\\\",\\\"string\\\":\\\"S7yzDlx4A4a9p1xY6LEPQeu3HO0wAkM6OtToFnFURjlFDaKIeuHsHbNIt6RsxuZqcg9ZBNmym2\\\"}}\",\"string\":\"S7yzDlx4A4a9p1xY6LEPQeu3HO0wAkM6OtToFnFURjlFDaKIeuHsHbNIt6RsxuZqcg9ZBNmym2\"}}","{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\Id\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\AlphanumericText\\\",\\\"__data__\\\":{\\\"text\\\":\\\"{\\\\\\\"__class__\\\\\\\":\\\\\\\"Darling\\\\\\\\\\\\\\\\PHPTextTypes\\\\\\\\\\\\\\\\classes\\\\\\\\\\\\\\\\strings\\\\\\\\\\\\\\\\Text\\\\\\\",\\\\\\\"__data__\\\\\\\":{\\\\\\\"string\\\\\\\":\\\\\\\"JLiEO9SubUzhiFHgfkbzu2Ly1LNI9XCYyHMhl5eApcPwjzw88tP2TQp474Udm\\\\\\\"}}\\\",\\\"string\\\":\\\"JLiEO9SubUzhiFHgfkbzu2Ly1LNI9XCYyHMhl5eApcPwjzw88tP2TQp474Udm\\\"}}\",\"string\":\"JLiEO9SubUzhiFHgfkbzu2Ly1LNI9XCYyHMhl5eApcPwjzw88tP2TQp474Udm\"}}"]]}
 */

```

### Encoding an Iterator

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * an iterator as json.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAnIterator.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;

/** @implements Iterator<int> */
class exampleIterator implements Iterator {
    private int $position = 0;

    /** @var array<int> $ints */
    private array $ints = [];

    public function __construct(int ...$ints) {
        foreach($ints as $id) {
            $this->ints[] = $id;
        }
    }

    public function rewind(): void {
        $this->position = 0;
    }

    public function current(): int {
        return $this->ints[$this->position];
    }

    public function key(): int {
        return $this->position;
    }

    public function next(): void {
        if($this->position < (count($this->ints) - 1)) {
            ++$this->position;
        } else {
            $this->position = 0;
        }
    }

    public function previous(): void {
        if($this->position > 0) {
            --$this->position;
        } else {
            $this->position = count($this->ints) - 1;
        }
    }

    public function valid(): bool {
        return isset($this->array[$this->position]);
    }
}

$iterator = new exampleIterator(1, 2, 3, 4, 5);
$iterator->previous();
$iterator->previous();
$iterator->previous();
$iterator->next();

$jsonEncodedIterator = new Json($iterator);

echo $jsonEncodedIterator . PHP_EOL;

/**
 * example output:
 *
 * {"__class__":"exampleIterator","__data__":{"position":3,"ints":[1,2,3,4,5]}}
 *
 */

```

### Encoding a Closure

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a closure as json.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAClosure.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPMockingUtilities\classes\mock\values\MockClosure;

$closure = new MockClosure();

$jsonEncodedClosure = new Json($closure->value());

echo $jsonEncodedClosure . PHP_EOL;

/**
 * example output:
 *
 * {"__class__":"Closure","__data__":[]}
 *
 */

```

### Encoding a valid json string

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a valid json string.
 *
 * Note:
 *
 * When a valid json string is encoded via a Json instance no
 * encoding actually occurs since the string is already valid
 * json.
 *
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAValidJsonString.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;

$validJsonString = json_encode([1, 2, 3, 'foo' => ['bar', 'baz']]);

$jsonEncodedValidJsonString = new Json($validJsonString);

echo $validJsonString . PHP_EOL;
echo $jsonEncodedValidJsonString . PHP_EOL;

/**
 * example output:
 *
 * {"0":1,"1":2,"2":3,"foo":["bar","baz"]}
 * {"0":1,"1":2,"2":3,"foo":["bar","baz"]}
 *
 */

```

### Encoding a \Darling\PHPJsonUtilities\classes\encoded\data\Json instance

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a Json instance as json.
 *
 * Note:
 *
 * When a Json instance is used to encode another Json instance no
 * encoding actually occurs, instead the Json instance performing
 * the encoding becomes a clone of the Json instance being encoded.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAJsonInstance.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPTextTypes\classes\strings\Id;


$jsonInstance = new Json(new Id());

$jsonEncodedJsonInstance = new Json($jsonInstance);

echo $jsonInstance . PHP_EOL;
echo $jsonEncodedJsonInstance . PHP_EOL;

/**
 * example output:
 *
 * {"__class__":"Darling\\PHPTextTypes\\classes\\strings\\Id","__data__":{"text":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\AlphanumericText\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\Text\\\",\\\"__data__\\\":{\\\"string\\\":\\\"2h6YHSSUpZp5T1Q3iaYgqxthm8n3FWGeycV8AsEr9UhzuvYvD3JWyBkbsDzT0f\\\"}}\",\"string\":\"2h6YHSSUpZp5T1Q3iaYgqxthm8n3FWGeycV8AsEr9UhzuvYvD3JWyBkbsDzT0f\"}}","string":"2h6YHSSUpZp5T1Q3iaYgqxthm8n3FWGeycV8AsEr9UhzuvYvD3JWyBkbsDzT0f"}}
 * {"__class__":"Darling\\PHPTextTypes\\classes\\strings\\Id","__data__":{"text":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\AlphanumericText\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\Text\\\",\\\"__data__\\\":{\\\"string\\\":\\\"2h6YHSSUpZp5T1Q3iaYgqxthm8n3FWGeycV8AsEr9UhzuvYvD3JWyBkbsDzT0f\\\"}}\",\"string\":\"2h6YHSSUpZp5T1Q3iaYgqxthm8n3FWGeycV8AsEr9UhzuvYvD3JWyBkbsDzT0f\"}}","string":"2h6YHSSUpZp5T1Q3iaYgqxthm8n3FWGeycV8AsEr9UhzuvYvD3JWyBkbsDzT0f"}}
 *
 */

```

# JsonDecoder

A `\Darling\PHPJsonUtilities\classes\decoders\JsonDecoder` can
be used to decode values that were encoded as `json` via a
`\Darling\PHPJsonUtilities\classes\encoded\data\Json` instance.

Note:

```
An instance of a class that defines readonly properties can be
encoded as `json` via a `Json` instance, but can only be decoded
via a `JsonDecoder` to an object instance of the same type.

When a `Json` encoded object that defines readonly properites is
decoded via a `JsonDecoder`, the values of any properties that were
defined as readonly by the original object instance may not match
their original values! This only applies to readonly properites,
all other properites will be still be decoded to their original
value.

```

Note:

```
A JsonDecoder will always decode valid json.

If the encoded value was a valid json string, or a Json instance,
then it will be completely decoded by the JsonDecoder->decode()
method to the orginal value represented by the valid json string
or Json instance.

In other words, the JsonDecoder->decode() method will never return
an Json instance or a valid json string, it will always return the
actual value that was encoded as json.

```

Examples:

### Encoding and decoding an Object instance

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode an
 * object instance as json, and then decode it via a JsonDecoder.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAndDecodingAnObjectInstance.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPTextTypes\classes\strings\Id;

$originalObjectInstance = new Id();

$jsonEncodedObject = new Json($originalObjectInstance);

$jsonDecoder = new JsonDecoder();

echo 'original object' . PHP_EOL;
var_dump($originalObjectInstance);
echo 'decoded object' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedObject));

/**
 * example output:
 *
 * ```
 * original object
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAnObjectInstance.php:40:
 * class Darling\PHPTextTypes\classes\strings\Id#3 (2) {
 *   private string $string =>
 *   string(65) "F9o8cfwrnxxTENPmTCfdaJsgpXeZEseCM4cvyKNo0ii0EzBYmbHJbDHUVMIV345gn"
 *   private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *   class Darling\PHPTextTypes\classes\strings\AlphanumericText#2 (2) {
 *     private string $string =>
 *     string(65) "F9o8cfwrnxxTENPmTCfdaJsgpXeZEseCM4cvyKNo0ii0EzBYmbHJbDHUVMIV345gn"
 *     private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *     class Darling\PHPTextTypes\classes\strings\Text#4 (1) {
 *       private string $string =>
 *       string(65) "F9o8cfwrnxxTENPmTCfdaJsgpXeZEseCM4cvyKNo0ii0EzBYmbHJbDHUVMIV345gn"
 *     }
 *   }
 * }
 * decoded object
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAnObjectInstance.php:42:
 * class Darling\PHPTextTypes\classes\strings\Id#12 (2) {
 *   private string $string =>
 *   string(65) "F9o8cfwrnxxTENPmTCfdaJsgpXeZEseCM4cvyKNo0ii0EzBYmbHJbDHUVMIV345gn"
 *   private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *   class Darling\PHPTextTypes\classes\strings\AlphanumericText#20 (2) {
 *     private string $string =>
 *     string(65) "F9o8cfwrnxxTENPmTCfdaJsgpXeZEseCM4cvyKNo0ii0EzBYmbHJbDHUVMIV345gn"
 *     private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *     class Darling\PHPTextTypes\classes\strings\Text#15 (1) {
 *       private string $string =>
 *       string(65) "F9o8cfwrnxxTENPmTCfdaJsgpXeZEseCM4cvyKNo0ii0EzBYmbHJbDHUVMIV345gn"
 *     }
 *   }
 * }
 *
 * ```
 *
 */

```

### Encoding and decoding an Object instance that defines readonly properties

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode an
 * object instance that defines readonly properties as json, and
 * then decode it via a JsonDecoder.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAndDecodingAnObjectInstanceThatDefinesReadonlyProperties.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json;

class DefinesReadonlyProperties
{

    public function __construct(private readonly int $int) {}

    public function getInt(): int
    {
        return $this->int;
    }
}

$originalObjectInstance = new DefinesReadonlyProperties(10);

$jsonEncodedObject = new Json($originalObjectInstance);

$jsonDecoder = new JsonDecoder();

echo 'original object' . PHP_EOL;
var_dump($originalObjectInstance);
echo 'decoded object' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedObject));

/**
 * Notice that properties that are defined as readonly are decoded to
 * the correct type, but may not be decoded to their original value.
 * This only applies to readonly properties.
 *
 * example output:
 *
 * ```
 * original object
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAnObjectInstanceThatDefinesReadonlyProperties.php:51:
 * class DefinesReadonlyProperties#3 (1) {
 *   private readonly int $int =>
 *   int(10)
 * }
 * decoded object
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAnObjectInstanceThatDefinesReadonlyProperties.php:53:
 * class DefinesReadonlyProperties#10 (1) {
 *   private readonly int $int =>
 *   int(5681945402744091890)
 * }
 *
 * ```
 *
 */

```

### Encoding and decoding a string

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a string as json, and decode it via a JsonDecoder instance.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAString.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPMockingUtilities\classes\mock\values\MockString;

$string = new MockString();

$jsonEncodedString = new Json($string->value());

$jsonDecoder = new JsonDecoder();

echo 'original string' . PHP_EOL;
var_dump($string->value());

echo 'decoded string' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedString));

/**
 * example output:
 *
 * ```
 * original string
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAString.php:40:
 * string(49) "MockStringEJ8pnCBUL22Pgiau8vqJHa3XYoqRtvlVdeM1F5k"
 * decoded string
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAString.php:43:
 * string(49) "MockStringEJ8pnCBUL22Pgiau8vqJHa3XYoqRtvlVdeM1F5k"
 *
 * ```
 *
 */

```

### Encoding and decoding an int

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * an int as json, and decode it via a JsonDecoder instance.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAnInt.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPMockingUtilities\classes\mock\values\MockInt;

$int = new MockInt();

$jsonEncodedInt = new Json($int->value());

$jsonDecoder = new JsonDecoder();

echo 'original int' . PHP_EOL;
var_dump($int->value());

echo 'decoded int' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedInt));

/**
 * example output:
 *
 * ```
 * original int
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAnInt.php:40:
 * int(2093209321154253834)
 * decoded int
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAnInt.php:43:
 * int(2093209321154253834)
 *
 * ```
 *
 */

```

### Encoding and decoding a float

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a float as json, and decode it via a JsonDecoder instance.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAFloat.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPMockingUtilities\classes\mock\values\MockFloat;

$float = new MockFloat();

$jsonEncodedFloat = new Json($float->value());

$jsonDecoder = new JsonDecoder();

echo 'original float' . PHP_EOL;
var_dump($float->value());

echo 'decoded float' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedFloat));

/**
 * example output:
 *
 * ```
 * original float
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAFloat.php:40:
 * double(1512273.8)
 * decoded float
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAFloat.php:43:
 * double(1512273.8)
 *
 * ```
 *
 */

```

### Encoding and decoding a bool

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a bool as json, and decode it via a JsonDecoder instance.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingABool.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPMockingUtilities\classes\mock\values\MockBool;

$bool = new MockBool();

$jsonEncodedBool = new Json($bool->value());

$jsonDecoder = new JsonDecoder();

echo 'original bool' . PHP_EOL;
var_dump($bool->value());

echo 'decoded bool' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedBool));

/**
 * example output:
 *
 * ```
 * original bool
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingABool.php:40:
 * bool(false)
 * decoded bool
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingABool.php:43:
 * bool(false)
 *
 * ```
 *
 */

```

### Encoding and decoding an array

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * an array as json, and decode it via a JsonDecoder instance.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAnArray.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPMockingUtilities\classes\mock\values\MockBool;
use \Darling\PHPMockingUtilities\classes\mock\values\MockClosure;
use \Darling\PHPMockingUtilities\classes\mock\values\MockFloat;
use \Darling\PHPMockingUtilities\classes\mock\values\MockInt;
use \Darling\PHPMockingUtilities\classes\mock\values\MockMixedValue;
use \Darling\PHPMockingUtilities\classes\mock\values\MockString;
use \Darling\PHPTextTypes\classes\strings\Id;

$bool = new MockBool();
$closure = new MockClosure();
$float = new MockFloat();
$int = new MockInt();
$mixed = new MockMixedValue();
$string = new MockString();

 *
 * Note: Nested objects and arrays will also be properly encoded.
 *
 */
$array = [
    $bool->value(),
    $closure->value(),
    $float->value(),
    $int->value(),
    $mixed->value(),
    $string->value(),
    'nested-array' => [
        [
            new Id(),
            new Id(),
            new Id(),
        ]
    ]
];
$jsonEncodedArray = new Json($array);

$jsonDecoder = new JsonDecoder();

echo 'original array' . PHP_EOL;
var_dump($array);

echo 'decoded array' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedArray));

/**
 * example output:
 *
 * ```
 * original array
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAnArray.php:70:
 * array(7) {
 *   [0] =>
 *   bool(false)
 *   [1] =>
 *   class Closure#8 (1) {
 *       virtual $closure =>
 *       "$this->Darling\PHPMockingUtilities\classes\mock\values\{closure}"
 *     public $this =>
 *     class Darling\PHPMockingUtilities\classes\mock\values\MockClosure#2 (0) {
 *     }
 *   }
 *   [2] =>
 *   double(665387.83333333)
 *   [3] =>
 *   int(3797309511412571283)
 *   [4] =>
 *   string(62) "q3vIwEMKpostgOCBFePmfdr6hyUXGN91AWaD8Qzj2VHZc5bTYiklL0uJx7nSR4"
 *   [5] =>
 *   string(49) "MockStringYkW2R9URVtUiTrlSNodhLmLSCBP3E5fD7fcyGDd"
 *   'nested-array' =>
 *   array(1) {
 *     [0] =>
 *     array(3) {
 *       [0] =>
 *       class Darling\PHPTextTypes\classes\strings\Id#7 (2) {
 *         ...
 *       }
 *       [1] =>
 *       class Darling\PHPTextTypes\classes\strings\Id#12 (2) {
 *         ...
 *       }
 *       [2] =>
 *       class Darling\PHPTextTypes\classes\strings\Id#15 (2) {
 *         ...
 *       }
 *     }
 *   }
 * }
 * decoded array
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAnArray.php:73:
 * array(7) {
 *   [0] =>
 *   bool(false)
 *   [1] =>
 *   class Closure#25 (1) {
 *       virtual $closure =>
 *       "$this->Darling\PHPMockingUtilities\classes\mock\values\{closure}"
 *     public $this =>
 *     class Darling\PHPMockingUtilities\classes\mock\values\MockClosure#21 (0) {
 *     }
 *   }
 *   [2] =>
 *   double(665387.83333333)
 *   [3] =>
 *   int(3797309511412571283)
 *   [4] =>
 *   string(62) "q3vIwEMKpostgOCBFePmfdr6hyUXGN91AWaD8Qzj2VHZc5bTYiklL0uJx7nSR4"
 *   [5] =>
 *   string(49) "MockStringYkW2R9URVtUiTrlSNodhLmLSCBP3E5fD7fcyGDd"
 *   'nested-array' =>
 *   array(1) {
 *     [0] =>
 *     array(3) {
 *       [0] =>
 *       class Darling\PHPTextTypes\classes\strings\Id#29 (2) {
 *         ...
 *       }
 *       [1] =>
 *       class Darling\PHPTextTypes\classes\strings\Id#43 (2) {
 *         ...
 *       }
 *       [2] =>
 *       class Darling\PHPTextTypes\classes\strings\Id#46 (2) {
 *         ...
 *       }
 *     }
 *   }
 * }
 *
 * ```
 *
 */

```

### Encoding and decoding an Iterator

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * an iterator as json, and decode it via a JsonDecoder instance.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAnIterator.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;

/** @implements Iterator<int> */
class exampleIterator implements Iterator {
    private int $position = 0;

    /** @var array<int> $ints */
    private array $ints = [];

    public function __construct(int ...$ints) {
        foreach($ints as $id) {
            $this->ints[] = $id;
        }
    }

    public function rewind(): void {
        $this->position = 0;
    }

    public function current(): int {
        return $this->ints[$this->position];
    }

    public function key(): int {
        return $this->position;
    }

    public function next(): void {
        if($this->position < (count($this->ints) - 1)) {
            ++$this->position;
        } else {
            $this->position = 0;
        }
    }

    public function previous(): void {
        if($this->position > 0) {
            --$this->position;
        } else {
            $this->position = count($this->ints) - 1;
        }
    }

    public function valid(): bool {
        return isset($this->array[$this->position]);
    }
}

$iterator = new exampleIterator(1, 2, 3, 4, 5);
$iterator->previous();
$iterator->previous();
$iterator->previous();
$iterator->next();

$jsonEncodedIterator = new Json($iterator);

$jsonDecoder = new JsonDecoder();

echo 'original iterator' . PHP_EOL;
var_dump($iterator);

echo 'decoded iterator' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedIterator));

/**
 * example output:
 *
 * ```
 * original iterator
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAnIterator.php:89:
 * class exampleIterator#3 (2) {
 *   private int $position =>
 *   int(3)
 *   private array $ints =>
 *   array(5) {
 *     [0] =>
 *     int(1)
 *     [1] =>
 *     int(2)
 *     [2] =>
 *     int(3)
 *     [3] =>
 *     int(4)
 *     [4] =>
 *     int(5)
 *   }
 * }
 * decoded iterator
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAnIterator.php:92:
 * class exampleIterator#10 (2) {
 *   private int $position =>
 *   int(3)
 *   private array $ints =>
 *   array(5) {
 *     [0] =>
 *     int(1)
 *     [1] =>
 *     int(2)
 *     [2] =>
 *     int(3)
 *     [3] =>
 *     int(4)
 *     [4] =>
 *     int(5)
 *   }
 * }
 *
 * ```
 *
 */

```

### Encoding and decoding a Closure

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a closure as json, and decode it via a JsonDecoder instance.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAClosure.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPMockingUtilities\classes\mock\values\MockClosure;

$closure = new MockClosure();

$jsonEncodedClosure = new Json($closure->value());

$jsonDecoder = new JsonDecoder();

echo 'original closure' . PHP_EOL;
var_dump($closure->value());

echo 'decoded closure' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedClosure));

/**
 * example output:
 *
 * ```
 * original closure
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAClosure.php:40:
 * class Closure#5 (1) {
 *   virtual $closure =>
 *   "$this->Darling\PHPMockingUtilities\classes\mock\values\{closure}"
 *   public $this =>
 *   class Darling\PHPMockingUtilities\classes\mock\values\MockClosure#3 (0) {
 *   }
 * }
 * decoded closure
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAClosure.php:43:
 * class Closure#9 (1) {
 *   virtual $closure =>
 *   "$this->Darling\PHPMockingUtilities\classes\mock\values\{closure}"
 *   public $this =>
 *   class Darling\PHPMockingUtilities\classes\mock\values\MockClosure#8 (0) {
 *   }
 * }
 *
 * ```
 *
 */

```

### Encoding and decoding a valid json string

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a valid json string as json, and decode it via a JsonDecoder
 * instance.
 *
 * Note:
 *
 * When a valid json string is encoded via a Json instance no
 * encoding actually occurs since the string is already valid
 * json.
 *
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAValidJsonString.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;

$validJsonString = json_encode([1, 2, 3, 'foo' => ['bar', 'baz']]);

$jsonEncodedValidJsonString = new Json($validJsonString);

$jsonDecoder = new JsonDecoder();

echo 'original json string' . PHP_EOL;
var_dump($validJsonString);

echo 'decoded json string' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedValidJsonString));

/**
 * Note:
 *
 * A JsonDecoder will always decode valid json.
 *
 * If the encoded value was a valid json string then it will
 * be completely decoded by the JsonDecoder->decode() method.
 *
 * example output:
 *
 * original json string
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAValidJsonString.php:47:
 * string(39) "{"0":1,"1":2,"2":3,"foo":["bar","baz"]}"
 * decoded json string
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAValidJsonString.php:50:
 * array(4) {
 *   [0] =>
 *   int(1)
 *   [1] =>
 *   int(2)
 *   [2] =>
 *   int(3)
 *   'foo' =>
 *   array(2) {
 *     [0] =>
 *     string(3) "bar"
 *     [1] =>
 *     string(3) "baz"
 *   }
 * }
 *
 */

```

### Encoding and decoding a Darling\PHPJsonUtilities\classes\encoded\data\Json instance

```
<?php

/**
 * This file demonstrates how to use a Json instance to encode
 * a Json instance as json, and decode it via a JsonDecoder instance.
 *
 * Note:
 *
 * When a Json instance is used to encode another Json instance no
 * encoding actually occurs, instead the Json instance performing
 * the encoding becomes a clone of the Json instance being encoded.
 *
 * This example should be run from this library's examples directory.
 *
 * For example:
 *
 * ```
 * php ./examples/exampleOfEncodingAJsonInstance.php
 *
 * ```
 *
 */

require_once(
    str_replace('examples' , '', __DIR__) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'autoload.php'
);

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPTextTypes\classes\strings\Id;


$jsonInstance = new Json(new Id());

$jsonEncodedJsonInstance = new Json($jsonInstance);

$jsonDecoder = new JsonDecoder();

echo 'original json instance' . PHP_EOL;
var_dump($jsonInstance);

echo 'decoded json instance' . PHP_EOL;
var_dump($jsonDecoder->decode($jsonEncodedJsonInstance));

/**
 * Note:
 *
 * A JsonDecoder will always decode valid json.
 *
 * If the encoded value was a Json instance then it will
 * be completely decoded by the JsonDecoder->decode() method.
 *
 * example output:
 *
 * ```
 * original json instance
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAJsonInstance.php:47:
 * class Darling\PHPJsonUtilities\classes\encoded\data\Json#3 (1) {
 *   private string $string =>
 *   string(580) "{"__class__":"Darling\\PHPTextTypes\\classes\\strings\\Id","__data__":{"text":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\AlphanumericText\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\Text\\\",\\\"__data__\\\":{\\\"string\\\":\\\"ghnjyBzmZprwwvSKIKFRFd0ibaoVUZ9WACbBEcXUwEeLq1MHrfxXuI01Op41GQ8lWQe6Ylxh\\\"}}\",\"string\":\"GhnjyBzmZprwwvSKIKFRFd0ibaoVUZ9WACbBEcXUwEeLq1MHrfxXuI01Op41GQ8lWQe6Ylxh\"}}","string":"GhnjyBz"...
 * }
 * decoded json instance
 * /home/darling/Git/PHPJsonUtilities/examples/exampleOfEncodingAndDecodingAJsonInstance.php:50:
 * class Darling\PHPTextTypes\classes\strings\Id#13 (2) {
 *   private string $string =>
 *   string(72) "GhnjyBzmZprwwvSKIKFRFd0ibaoVUZ9WACbBEcXUwEeLq1MHrfxXuI01Op41GQ8lWQe6Ylxh"
 *   private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *   class Darling\PHPTextTypes\classes\strings\AlphanumericText#18 (2) {
 *     private string $string =>
 *     string(72) "GhnjyBzmZprwwvSKIKFRFd0ibaoVUZ9WACbBEcXUwEeLq1MHrfxXuI01Op41GQ8lWQe6Ylxh"
 *     private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *     class Darling\PHPTextTypes\classes\strings\Text#10 (1) {
 *       private string $string =>
 *       string(72) "ghnjyBzmZprwwvSKIKFRFd0ibaoVUZ9WACbBEcXUwEeLq1MHrfxXuI01Op41GQ8lWQe6Ylxh"
 *     }
 *   }
 * }
 *
 * ```
 *
 */

```

