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
    public function testData(): array
    {
        $all = [
            new TestClassCoversMultipleEdgeCases(
                strval(json_encode($this->randomChars())),
                new ObjectReflection(new Id()),
                new Json(
                    json_encode(
                        [
                            $this->randomChars()
                            =>
                            $this->randomChars()
                        ]
                    )
                ),
                new Id(),
                function() : void { },
                    new TestIterator,
                    [
                        $this->randomClassStringOrObjectInstance(),
                        $this->randomObjectInstance(),
                        $this->randomChars(),
                        $this->randomChars() => $this->randomChars(),
                        [$this->randomChars() => $this->randomChars()],
                        [
                            $this->randomClassStringOrObjectInstance(),
                            $this->randomObjectInstance(),
                            $this->randomChars(),
                            $this->randomChars() => $this->randomChars(),
                            [
                                $this->randomChars()
                                =>
                                $this->randomChars()
                            ],
                            new Json(
                                json_encode(
                                    [
                                        $this->randomChars()
                                        =>
                                        $this->randomChars()
                                    ]
                                )
                            ),
                        ],
                    ],
            ),
            $this->randomChars(),
            $this->randomClassStringOrObjectInstance(),
            $this->randomFloat(),
            $this->randomObjectInstance(),
            'foo',
            0,
            1,
            1.2,
            [
                1,
                true,
                false,
                null,
                'string',
                [],
                new Text($this->randomChars()),
                'baz' => ['secondary_id' => new Id()],
                'foo' => 'bar',
                'id' => new Id(),
            ],
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
            new TestClassThatDefinesAPropertyThatAcceptsAJsonInstance(
                new Json(new Id()),
                new Id(), new Id()
            ),
            new TestIterator(),
            new Text(new Id()),
            new ReflectedBaseClass(),
            new \Directory(),
            null,
            true,
            new Json(new Id()),
            new Json(new Json(new Id())),
            new Json(new Json(new Json(new Id()))),
            new Json($this->randomClassStringOrObjectInstance()),
            new Json(json_encode(['foo', 'bar', 'baz'])),
            new ReflectionClass($this),
            new TestClassB(),
        ];
        $targeted = [
            new TestClassCoversMultipleEdgeCases(
                strval(json_encode($this->randomChars())),
                new ObjectReflection(new Id()),
                new Json(
                    json_encode(
                        [
                            $this->randomChars()
                            =>
                            $this->randomChars()
                        ]
                    )
                ),
                new Id(),
                function() : void { },
                    new TestIterator,
                    [
                        $this->randomClassStringOrObjectInstance(),
                        $this->randomObjectInstance(),
                        $this->randomChars(),
                        $this->randomChars() => $this->randomChars(),
                        [$this->randomChars() => $this->randomChars()],
                        [
                            $this->randomClassStringOrObjectInstance(),
                            $this->randomObjectInstance(),
                            $this->randomChars(),
                            $this->randomChars() => $this->randomChars(),
                            [
                                $this->randomChars()
                                =>
                                $this->randomChars()
                            ],
                            new Json(
                                json_encode(
                                    [
                                        $this->randomChars()
                                        =>
                                        $this->randomChars()
                                    ]
                                )
                            ),
                        ],
                    ],
            )
        ];
        return $targeted;
    }

    protected function randomData(): mixed
    {
        $data = $this->testData();
        return $data[array_rand($data)];
    }
}

