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
will have their property values preserved.

Examples:

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
