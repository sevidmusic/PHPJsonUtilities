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
    1. [Encoding an Object instance](#encodinganobjectinstance)
    2. [Encoding an Object instance that defines readonly properties](#encodinganobjectinstancethatdefinesreadonlyproperties)
    3. [Encoding a string](#encodingastring)
    4. [Encoding an int](#encodinganint)
    5. [Encoding a float](#encodingafloat)
    6. [Encoding a bool](#encodingabool)
    7. [Encoding an array](#encodinganarray)
    8. [Encoding an Iterable](#encodinganiterable)
    9. [Encoding a Closure](#encodingaclosure)
    10. [Encoding a valid json string](#encodingavalidjsonstring)
    11. [Encoding a \Darling\PHPJsonUtilities\classes\encoded\data\Json instance](#encodinga\Darling\PHPJsonUtilities\classes\encoded\data\Jsoninstance)
- [JsonDecoder](#darlingphpjsonutilitiesclassesdecodersjsondecoder)
    1. [Encoding and decoding an Object instance](#encodinganddecodinganobjectinstance)
    2. [Encoding and decoding an Object instance that defines readonly properties](#encodinganddecodinganobjectinstancethatdefinesreadonlyproperties)
    3. [Encoding and decoding a string](#encodinganddecodingastring)
    4. [Encoding and decoding an int](#encodinganddecodinganint)
    5. [Encoding and decoding a float](#encodinganddecodingafloat)
    6. [Encoding and decoding a bool](#encodinganddecodingabool)
    7. [Encoding and decoding an array](#encodinganddecodinganarray)
    8. [Encoding and decoding an Iterable](#encodinganddecodinganiterable)
    9. [Encoding and decoding a Closure](#encodinganddecodingaclosure)
    10. [Encoding and decoding a valid json string](#encodinganddecodingavalidjsonstring)
    11. [Encoding and decoding a \Darling\PHPJsonUtilities\classes\encoded\data\Json instance](#encodinganddecodinga\Darling\PHPJsonUtilities\classes\encoded\data\Jsoninstance)

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
