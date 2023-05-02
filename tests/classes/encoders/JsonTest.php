<?php

namespace Darling\PHPJsonUtilities\tests\classes\encoders;

use \Darling\PHPJsonUtilities\classes\encoders\Json;
use \Darling\PHPJsonUtilities\tests\PHPJsonUtilitiesTest;
use \Darling\PHPJsonUtilities\tests\interfaces\encoders\JsonTestTrait;
use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPTextTypes\classes\strings\ClassString;
use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Directory;
use \ReflectionClass;

class JsonTest extends PHPJsonUtilitiesTest
{

    public const CLASS_INDEX = '__class__';

    public const DATA_INDEX = '__data__';

    /**
     * The JsonTestTrait defines common tests for implementations
     * of the Darling\PHPJsonUtilities\interfaces\encoders\Json
     * interface.
     *
     * @see JsonTestTrait
     *
     */
    use JsonTestTrait;

    public function setUp(): void
    {
        $values = [
            $this->randomChars(),
            $this->randomClassStringOrObjectInstance(),
            $this->randomFloat(),
            $this->randomObjectInstance(),
            ['1' => 1, 'foo' => 'bar', 'baz' => [1, 2, 3]],
            [1, 2, 3],
            [],
            function (): void {},
            json_encode("Foo bar baz"),
            json_encode($this->randomChars()),
            json_encode(['foo', 'bar', 'baz']),
            json_encode([1, 2, 3]),
            json_encode([PHP_INT_MIN, PHP_INT_MAX]),
            new Directory(),
            new Json($this->randomClassStringOrObjectInstance()),
            new Json(json_encode(['foo', 'bar', 'baz'])),
            new Reflection(new ClassString(Id::class)),
            new ReflectionClass($this),
        ];
        $data = $values[array_rand($values)];
        $this->setExpectedJsonString($data);
        $this->setJsonTestInstance(
            new Json($data)
        );
    }

}

