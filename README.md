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
alternative to `json_encode()` that can be used encode object
instances as `JSON` in a way that preserves their property values.

The following classes are provided by this library:

```
\Darling\PHPJsonUtilities\classes\encoded\data\Json

```
Which can be used to encode values of various types as valid `JSON`.

```
\Darling\PHPJsonUtilities\classes\decoders\JsonDecoder

```

Which can be used to decode values that were encoded as `JSON` via a
`Json` instance.

# Overview

- [Installation](#installation)
- [Examples](#examples)
      1. [Json](#json)
      1. [JsonDecoder](#jsondecoder)

# Installation

```
composer require darling/php-json-utilities

```

# Examples

### Json

The `\Darling\PHPJsonUtilities\classes\encoded\data\Json` can be used
to encode values of various types as `JSON`.

Any value that can be encoded as `JSON` via `json_encode()`
can be encoded as `JSON` via a
`\Darling\PHPJsonUtilities\classes\encoded\data\Json` instance.

Unlike with `json_encode()`, objects encoded as `JSON` via a
`\Darling\PHPJsonUtilities\classes\encoded\data\Json` instance
will have their property values preserved.

Example:

```
class A {

    private Closure $uninitializedProperty;

    private Closure $initializedProperty;

    public function __construct(Closure $closure) {
        $this->initializedProperty = $closure;
    }

}

$instance = new A(function(): void {});

$json = new \Darling\PHPJsonUtilities\classes\encoded\data\Json($instance);

echo json_encode($instance);

// example output:
{}

echo $json;

// example output:
{"__class__":"A","__data__":{"uninitializedProperty":null,"initializedProperty":"{\"__class__\":\"Closure\",\"__data__\":[]}"}}

```

### JsonDecoder

A JsonDecoder can be used to decode data that was encoded
as Json.

Example:

```
class A { private Closure $uninitializedProperty; private Closure $initializedProperty; public function __construct(Closure $closure) { $this->initializedProperty = $closure; } }

$instance = new A(function(): void {});

$json = new \Darling\PHPJsonUtilities\classes\encoded\data\Json($instance);

$jsonDecoder = new \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder();

var_dump($jsonDecoder->decode($json));

// example output:
class A#11 (2) {
  private Closure $uninitializedProperty =>
  *uninitialized*
  private Closure $initializedProperty =>
  class Closure#18 (1) {
      virtual $closure =>
      "$this->Darling\PHPMockingUtilities\classes\mock\values\{closure}"
    public $this =>
    class Darling\PHPMockingUtilities\classes\mock\values\MockClosure#17 (0) {
    }
  }
}

```


