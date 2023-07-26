<?php

namespace Darling\PHPJsonUtilities\tests;

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassA;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassB;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassDefinesReadOnlyProperties;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassThatDefinesAPropertyThatAcceptsAJsonInstance;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestIterator;
use \Darling\PHPJsonUtilities\tests\dev\test\classes\TestClassCoversMultipleEdgeCases;
use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPTextTypes\classes\strings\ClassString;
use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\Name;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\PrivateStaticProperties;
use \Darling\PHPUnitTestUtilities\traits\PHPUnitConfigurationTests;
use \Darling\PHPUnitTestUtilities\traits\PHPUnitRandomValues;
use \Darling\PHPUnitTestUtilities\traits\PHPUnitTestMessages;
use \Directory;
use \PHPUnit\Framework\TestCase;
use \ReflectionClass;
use \Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\ReflectedBaseClass;

/**
 * Defines common methods that may be useful to all roady test
 * classes.
 *
 * All roady test classes must extend from this class.
 *
 */
class PHPJsonUtilitiesTest extends TestCase
{
    use PHPUnitConfigurationTests;
    use PHPUnitRandomValues;
    use PHPUnitTestMessages;

    /**
     * Return an array of test data.
     *
     * @return array<mixed>
     *
     */
    protected function predefinedTestData(): array
    {
        $stdClassWithProperties = new \stdClass();
        $stdClassWithProperties->foo = 'bar';
        $stdClassWithProperties->baz = 'bazzer';
        $failing = [
            #$stdClassWithProperties, // fails, stdClass instances that are assigned properties are not properly encoded/decoded
            #new ReflectedBaseClass(), // fails because of failues with stdClass instances that are assigned properties
            #$this->randomChars(), // fails, i believe b/c fix to issue #69 results in original string being modified, which means a string with invalid utf-8 chars that is enocded to json will be decoded into a string with escapes for the invalid shars, this means the original string and the decoded string will not match.
        ];
        $passing = [
            $this->randomClassStringOrObjectInstance(),
            $this->randomFloat(),
            $this->randomObjectInstance(),
            0,
            1,
            1.2,
            [1, true, false, null, 'string', [], new Text(str_shuffle('abcdefg')), 'baz' => ['secondary_id' => new Id()], 'foo' => 'bar', 'id' => new Id(), ], // fails
            [],
            false,
            function (): void {},
            json_encode("Foo bar baz"),
            json_encode($this->randomChars()),
            json_encode(['foo', 'bar', 'baz']),
            json_encode([1, 2, 3]),
            json_encode([PHP_INT_MIN, PHP_INT_MAX]),
            new ClassString(Id::class),
            new Directory(),
            new Id(),
            new Json($this->randomClassStringOrObjectInstance()),
            new Json(json_encode(['foo', 'bar', 'baz'])),
            new Json(new Id()),
            new Json(new Json(new Id())),
            new Json(new Json(new Json(new Id()))),
            new ObjectReflection(new Id()),
            new PrivateStaticProperties(),
            new Reflection(new ClassString(Id::class)),
            new ReflectionClass(Id::class),
            new TestClassA(new Id(), new Name(new Text('Foo'))),
            new TestClassB(),
            new TestClassCoversMultipleEdgeCases( strval(json_encode(str_shuffle('abcdefg'))), new ObjectReflection(new Id()), new Json( json_encode( [ str_shuffle('abcdefg') => str_shuffle('abcdefg') ])), new Id(), function() : void { }, /* new TestIterator, # currently fails because a MockClassInstance cannot mock a class that expects an implementation of PHP's Iterator interface | re-enable once this issue is resolved */ [ $this->randomClassStringOrObjectInstance(), $this->randomObjectInstance(), str_shuffle('abcdefg'), str_shuffle('abcdefg') => str_shuffle('abcdefg'), [str_shuffle('abcdefg') => str_shuffle('abcdefg')], [ $this->randomClassStringOrObjectInstance(), $this->randomObjectInstance(), str_shuffle('abcdefg'), str_shuffle('abcdefg') => str_shuffle('abcdefg'), [ str_shuffle('abcdefg') => str_shuffle('abcdefg') ], new Json( json_encode( [ str_shuffle('abcdefg') => str_shuffle('abcdefg') ])), ], ],), // fails
            new TestClassDefinesReadOnlyProperties('foo'),
            new TestClassThatDefinesAPropertyThatAcceptsAJsonInstance(new Json(new Id()), new Id(), new Id()),
            new TestIterator(),
            new Text(new Id()),
            new \Directory(),
            null,
            str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'),
            true,
        ];
        return $passing;
    }

    protected function randomData(): mixed
    {
        $data = $this->predefinedTestData();
        return $data[array_rand($data)];
    }
}

