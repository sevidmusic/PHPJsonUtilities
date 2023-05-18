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

The main goal of this library is to provide an object oriented
alternative to `json_encode()` and `json_decode()` that can be
used encode object instances as `JSON` in a way that preserves
their property values.

The following classes are provided by this library:

```
\Darling\PHPJsonUtilities\classes\encoded\data\Json

```
Which is a `\Stringable` type that can be used to encode values of
various types as valid `JSON`.

```
\Darling\PHPJsonUtilities\classes\decoders\JsonDecoder

```

Which can be used to decode values that were encoded as `JSON` via a
`Json` instance.

# Overview

- [Installation](#installation)
- [Examples](#examples)
    1. [Json](#json)
    2. [JsonDecoder](#jsondecoder)

# Installation

```
composer require darling/php-json-utilities

```

# Examples

### Json

A `\Darling\PHPJsonUtilities\classes\encoded\data\Json` instance can
be used to encode values of various types as `JSON`.

Any value that can be encoded as `JSON` via `json_encode()`
can be encoded as `JSON` via a
`\Darling\PHPJsonUtilities\classes\encoded\data\Json` instance.

Unlike with `json_encode()`, objects encoded as `JSON` via a
`\Darling\PHPJsonUtilities\classes\encoded\data\Json` instance
will have their property values preserved.

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


### JsonDecoder

A JsonDecoder can be used to decode values that were encoded as
`JSON` via a `\Darling\PHPJsonUtilities\classes\encoded\data\Json`
instance.

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
 * Note:
 * At the moment arrays are decoded to an instance of `stdClass`.
 * This is an issue that is being addressed, in the future arrays
 * encoded as `JSON` via a
 * `\Darling\PHPJsonUtilities\classes\encoded\data\Json`
 * instance will be decoded to an array by
 * `\Darling\PHPJsonUtilities\classes\decoders\JsonDecoder->decode()`.
 * @see https://github.com/sevidmusic/PHPJsonUtilities/issues/36
 */

```

