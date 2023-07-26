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
        $failing = [
#            new ReflectedBaseClass(), // fails
            /**
             * randomChars() fails b/c it produces a string that
             * may contain invalid utf8 characters.
             *
             * When json_encode() encounters a string that contains
             * invalid utf8 characters it will return null.
             *
             * The solution is to use JSON_INVALID_UTF8_SUBSTITUTE to
             * convert invalid UTF-8 characters to \0xfffd.
             *
             * @see  https://www.php.net/manual/en/json.constants.php
             * @see https://stackoverflow.com/questions/4663743/how-to-keep-json-encode-from-dropping-strings-with-invalid-characters
             */
            $this->randomChars(),
        ];
        $passing = [
            new TestClassCoversMultipleEdgeCases( strval(json_encode(str_shuffle('abcdefg'))), new ObjectReflection(new Id()), new Json( json_encode( [ str_shuffle('abcdefg') => str_shuffle('abcdefg') ])), new Id(), function() : void { }, /* new TestIterator, # currently fails because a MockClassInstance cannot mock a class that expects an implementation of PHP's Iterator interface | re-enable once this issue is resolved */ [ $this->randomClassStringOrObjectInstance(), $this->randomObjectInstance(), str_shuffle('abcdefg'), str_shuffle('abcdefg') => str_shuffle('abcdefg'), [str_shuffle('abcdefg') => str_shuffle('abcdefg')], [ $this->randomClassStringOrObjectInstance(), $this->randomObjectInstance(), str_shuffle('abcdefg'), str_shuffle('abcdefg') => str_shuffle('abcdefg'), [ str_shuffle('abcdefg') => str_shuffle('abcdefg') ], new Json( json_encode( [ str_shuffle('abcdefg') => str_shuffle('abcdefg') ])), ], ],), // fails
            [1, true, false, null, 'string', [], new Text(str_shuffle('abcdefg')), 'baz' => ['secondary_id' => new Id()], 'foo' => 'bar', 'id' => new Id(), ], // fails
            $this->randomClassStringOrObjectInstance(),
            $this->randomFloat(),
            $this->randomObjectInstance(),
            'foo',
            0,
            1,
            1.2,
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
            new ObjectReflection(new Id()),
            new PrivateStaticProperties(),
            new Reflection(new ClassString(Id::class)),
            new TestClassA(new Id(), new Name(new Text('Foo'))),
            new TestClassDefinesReadOnlyProperties('foo'),
            new TestClassThatDefinesAPropertyThatAcceptsAJsonInstance(new Json(new Id()), new Id(), new Id()),
            new TestIterator(),
            new Text(new Id()),
            new \Directory(),
            null,
            true,
            new Json(new Id()),
            new Json(new Json(new Id())),
            new Json(new Json(new Json(new Id()))),
            new Json($this->randomClassStringOrObjectInstance()),
            new Json(json_encode(['foo', 'bar', 'baz'])),
            new ReflectionClass(Id::class),
            new TestClassB(),
        ];
        return $failing;
    }

    protected function randomData(): mixed
    {
        $data = $this->predefinedTestData();
        return $data[array_rand($data)];
    }
}

