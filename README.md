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
```

### Encoding an Object instance that defines readonly properties

```
```

### Encoding a string

```
```

### Encoding an int

```
```

### Encoding a float

```
```

### Encoding a bool

```
```

### Encoding an array

```
```

### Encoding an Iterable

```
```

### Encoding a Closure

```
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
