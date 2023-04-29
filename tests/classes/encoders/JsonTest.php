<?php

namespace Darling\PHPJsonUtilities\tests\classes\encoders;

use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\ClassString;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;
use \Darling\PHPJsonUtilities\classes\encoders\Json;
use \Darling\PHPJsonUtilities\tests\PHPJsonUtilitiesTest;
use \Darling\PHPJsonUtilities\tests\interfaces\encoders\JsonTestTrait;
use \Directory;
use \ReflectionClass;

class JsonTest extends PHPJsonUtilitiesTest
{


    public const CLASS_INDEX = '__class__';

    public const DATA_INDEX = '__data__';

    /**
     * The JsonTestTrait defines
     * common tests for implementations of the
     * Darling\PHPJsonUtilities\interfaces\encoders\Json
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
            $this->randomObjectInstance(),
            new Directory(),
            new ReflectionClass($this),
            function (): void {},
            [],
            [1, 2, 3],
            ['1' => 1, 'foo' => 'bar', 'baz' => [1, 2, 3]],
            new Json($this->randomClassStringOrObjectInstance()),
            new Reflection(new ClassString(Id::class)),
        ];
        $data = $values[array_rand($values)];
        $this->setExpectedJsonString($data);
        $this->setJsonTestInstance(
            new Json($data)
        );
    }

}

