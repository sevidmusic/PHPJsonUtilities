<?php

require(
    str_replace(
        'tests' . DIRECTORY_SEPARATOR . 'integration',
        'vendor',
        __DIR__,
    ) . DIRECTORY_SEPARATOR . 'autoload.php'
);

use \Darling\PHPMockingUtilities\classes\mock\values\MockClassInstance;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection as DarlingReflection;
use \Darling\PHPTextTypes\classes\strings\ClassString;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;

enum FooBarBaz
{
    case Foo;
    case Bar;
    case Baz;
}

enum FooBarBazBacked: string
{
    case Foo = 'foo';
    case Bar = 'bar';
    case Baz = 'baz';
}

function bazzerBazFoo(): void {}

function intGenerator(int $max): Generator {
    for ($i = 1; $i <= $max; $i++) {
        yield $i;
    }
}

/**
 * Return an instance of either a ReflectionClass or
 * a ReflectionProperty.
 *
 * @return ReflectionClass<object>|ReflectionProperty
 *
 */
function instanceOfAStandardLibraryReflectionType(): mixed
{
    $referencedValue = 'value';
    /** @var ReflectionReference $reflectionReference */
    $reflectionReference = ReflectionReference::fromArrayElement(
        [&$referencedValue],
        0
    );
    /** @var array<ReflectionClass<object>|ReflectionProperty> $classes */
    $classes = [
        $reflectionReference,
        new DarlingReflection(new ClassString(Text::class)),
        new Reflection(),
        new ReflectionException(),
        new ReflectionFiber( new Fiber(function(): string { return 'foo'; })),
        new ReflectionGenerator(intGenerator(PHP_INT_MAX)),
        new ReflectionIntersectionType(),
        new ReflectionNamedType(),
        new ReflectionUnionType(),
#        The following FAIL to be decoded because they define read-only properties
#        new ReflectionParameter([Text::class, '__construct'], 0),
#        new ReflectionFunction(function(): void {}),
#        new ReflectionMethod(Text::class, '__toString'),
#        new ReflectionExtension('curl'),
#        new ReflectionClassConstant(MockClassInstance::class, 'CONSTRUCT'),
#        new ReflectionClass(Text::class),
#        new ReflectionProperty(Text::class, 'string'),
#        new ReflectionObject(new Text('foo bar baz')),
#        new ReflectionEnum(FooBarBaz::class), # Fails
#        new ReflectionEnumBackedCase(FooBarBazBacked::class, 'Bar'),
#        new ReflectionEnumUnitCase(FooBarBaz::class, 'Foo'),
#        // NOT TESTED YET
#        new ReflectionZendExtension(''),
#        new ReflectionAttribute(),
   ];
    return $classes[array_rand($classes)];
}

$originalObject = instanceOfAStandardLibraryReflectionType();
$testJson = new Json($originalObject);
$jsonDecoder = new JsonDecoder();
$decodedObject = $jsonDecoder->decode($testJson);

if(is_object($decodedObject) && ($decodedObject == $originalObject)) {
    echo PHP_EOL .
        'Test Passed: Instance of Reflection classes ' .
        'provided by PHP\'s standard library can be encoded ' .
        'as Json and decoded from Json.' . PHP_EOL;
    file_put_contents(
        '/tmp/darlingTestJson.json',
        PHP_EOL . $testJson
    );
} else {
    echo PHP_EOL . 'Test Failed' . PHP_EOL;
    die('The following integration test failed: ' . PHP_EOL . __DIR__ . DIRECTORY_SEPARATOR . __FILE__);
}

