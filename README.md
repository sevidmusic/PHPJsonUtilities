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

- [Json](#darlingphpjsonutilitiesclassesencodeddatajson)
    1. [Encoding an Object instance](#encoding-an-object-instance)
    2. [Encoding an Object instance that defines readonly properties](#encoding-an-object-instance-that-defines-readonly-properties)
    3. [Encoding a string](#encoding-a-string)
    4. [Encoding an int](#encoding-an-int)
    5. [Encoding a float](#encoding-a-float)
    6. [Encoding a bool](#encoding-a-bool)
    7. [Encoding an array](#encoding-an-array)
    8. [Encoding an Iterable](#encoding-an-iterable)
    9. [Encoding a Closure](#encoding-a-closure)
    10. [Encoding a valid json string](#encoding-a-valid-json-string)
    11. [Encoding a DarlingPHPJsonUtilitiesclassesencodeddataJson instance](#encoding-a-darlingphpjsonutilitiesclassesencodeddatajson-instance)

- [JsonDecoder](#darlingphpjsonutilitiesclassesdecodersjsondecoder)

# Installation

```
composer require darling/php-json-utilities
```

### `\Darling\PHPJsonUtilities\classes\encoded\data\Json`

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

/**
 * Example of encoding an object:
 */
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

/**
 * Example of encoding an object that defines readonly properties:
 */
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

/**
 * Example of encoding a string:
 */
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

/**
 * Example of encoding an int:
 */
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

/**
 * Example of encoding an float:
 */
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

/**
 * Example of encoding an bool:
 */
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

/**
 * Example of encoding an array.
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

/**
 * Example of encoding an iterator:
 */
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

/**
 * Example of encoding an closure:
 */
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
```

### Encoding a \Darling\PHPJsonUtilities\classes\encoded\data\Json instance

```
```

### `\Darling\PHPJsonUtilities\classes\decoders\JsonDecoder`

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

Examples:

```

```
