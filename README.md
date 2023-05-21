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

$objectInstance = new Id();

$jsonEncodedObject = new Json($objectInstance);

echo $jsonEncodedObject . PHP_EOL;

// example output:
// {"__class__":"Darling\\PHPTextTypes\\classes\\strings\\Id","__data__":{"text":"{\"__class__\":\"Darling\\\\PHPTextTypes\\\\classes\\\\strings\\\\AlphanumericText\",\"__data__\":{\"text\":\"{\\\"__class__\\\":\\\"Darling\\\\\\\\PHPTextTypes\\\\\\\\classes\\\\\\\\strings\\\\\\\\Text\\\",\\\"__data__\\\":{\\\"string\\\":\\\"IxVFLvhpJCzvuEyoYjt3TqQL7xE4lSKaFgNhOTwRUjN8yiizaF7gfADZHVl7WJfmHdg52i0Nrl12Kc\\\"}}\",\"string\":\"IxVFLvhpJCzvuEyoYjt3TqQL7xE4lSKaFgNhOTwRUjN8yiizaF7gfADZHVl7WJfmHdg52i0Nrl12Kc\"}}","string":"IxVFLvhpJCzvuEyoYjt3TqQL7xE4lSKaFgNhOTwRUjN8yiizaF7gfADZHVl7WJfmHdg52i0Nrl12Kc"}}

$array = [1, 'foo' => 'bar',[null, false]];

$jsonEncodedArray = new Json($array);

echo $jsonEncodedArray . PHP_EOL;

// example output:
// {"0":1,"foo":"bar","1":[null,false]}

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

$jsonDecoder = new JsonDecoder();

$objectInstance = new Id();

$jsonEncodedObject = new Json($objectInstance);

$decodedObject = $jsonDecoder->decode($jsonEncodedObject);

var_dump($decodedObject);

/**
 * example output:
 *
 * class Darling\PHPTextTypes\classes\strings\Id#9 (2) {
 *   private string $string =>
 *   string(76) "GlyJ9DGMzRfbqXVvi2Z5orA8p4taCXguejgZNSTimGwo9EaqJjlNFzQLm8NCMFAhk3YlEcWYQwsc"
 *   private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *   class Darling\PHPTextTypes\classes\strings\AlphanumericText#17 (2) {
 *     private string $string =>
 *     string(76) "GlyJ9DGMzRfbqXVvi2Z5orA8p4taCXguejgZNSTimGwo9EaqJjlNFzQLm8NCMFAhk3YlEcWYQwsc"
 *     private Darling\PHPTextTypes\interfaces\strings\Text $text =>
 *     class Darling\PHPTextTypes\classes\strings\Text#18 (1) {
 *       private string $string =>
 *       string(76) "GlyJ9DGMzRfbqXVvi2Z5orA8p4taCXguejgZNSTimGwo9EaqJjlNFzQLm8NCMFAhk3YlEcWYQwsc"
 *     }
 *   }
 * }
 *
 */

$array = [1, 'foo' => 'bar',[null, false]];

$jsonEncodedArray = new Json($array);

$decodedArray = $jsonDecoder->decode($jsonEncodedArray);

var_dump($decodedArray);

/**
 * example output:
 *
 * class stdClass#12 (3) {
 *   public $0 =>
 *   int(1)
 *   public $foo =>
 *   string(3) "bar"
 *   public $1 =>
 *   array(2) {
 *     [0] =>
 *     NULL
 *     [1] =>
 *     bool(false)
 *   }
 * }
 *
 */

```

