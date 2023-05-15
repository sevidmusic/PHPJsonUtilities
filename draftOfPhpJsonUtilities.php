<?php

include('/home/darling/Git/PHPJsonUtilities/vendor/autoload.php');

use \Darling\PHPJsonUtilities\classes\decoders\JsonDecoder;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPMockingUtilities\classes\mock\values\MockClassInstance;
use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;
use \Darling\PHPReflectionUtilities\classes\utilities\Reflection;
use \Darling\PHPReflectionUtilities\interfaces\utilities\Reflection as ReflectionInterface;
use \Darling\PHPTextTypes\classes\strings\AlphanumericText;
use \Darling\PHPTextTypes\classes\strings\ClassString;
use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\Name;
use \Darling\PHPTextTypes\classes\strings\SafeText;
use \Darling\PHPTextTypes\classes\strings\Text;
use \Darling\PHPTextTypes\classes\strings\UnknownClass;
use \Darling\PHPUnitTestUtilities\Tests\dev\mock\classes\PrivateMethods;

final class TestClassA
{

    private mixed $uninitialized;

    public function __construct(private Id $id, private Name $name) {}


    public function id(): Id
    {
        $this->uninitialized = $this->id;
        return $this->id;
    }

    public function name(): Name
    {
        $this->uninitialized = $this->name;
        return $this->name;
    }

    public function uninitialized(): mixed
    {
        return $this->uninitialized;
    }

}

final class TestClassB
{

    public string $data = '';

    /**
     * @param array<mixed> $array
     */
    public function __construct(
        private array $array = [],
        private bool $bool = false,
        private float $float = 1.2345,
        private int $int = 12345,
        private string $string = '',
    )
    {
        $this->data = strval(
            json_encode(
                [
                    $this->array,
                    $this->bool,
                    $this->float,
                    $this->int,
                    $this->string
                ]
            )
        );
    }
}

/**
 * @template T
 * @implements Iterator<string>
 */
class TestIterator implements Iterator
{

    /**
     *
     * @param int $position
     * @param array<int, string> $array
     *
     */
    public function __construct(private int $position = 0, private array $array = []) {
        if(empty($this->array)) {
            $this->array = array( "foo", "bar", "baz", "bazzer");
        }
    }

    public function rewind(): void {
        $this->position = 0;
    }

    public function current(): string {
        return $this->array[$this->position];
    }

    public function key(): int {
        return $this->position;
    }

    public function next(): void {
        ++$this->position;
    }

    public function valid(): bool {
        return isset($this->array[$this->position]);
    }

}

$testObjects = [
    new TestClassA(new Id(), new Name(new Text('Name'))),
    new TestIterator(),
    new TestClassB(),
    new AlphanumericText(new Text('AlphanumericText')),
    new Id(),
    new Name(new Text('Name')),
    new SafeText(new Text('SafeText')),
    new Text('Text'),
    new UnknownClass(),
    new PrivateMethods(),
];

$testObject = $testObjects[array_rand($testObjects)];

$testJson = new Json($testObject);

$jsonDecoder = new JsonDecoder();

$decodedTestObject = $jsonDecoder->decode(
    $testJson
);

if(is_object($decodedTestObject)) {

    $mocker = new MockClassInstance(new ObjectReflection($decodedTestObject));

    $mockInstance = $mocker->mockInstance();

    var_dump('original type:', $testObject::class, 'decoded type', $decodedTestObject::class);

    var_dump(
        '$decodedTestObject matches $testObject',
        $decodedTestObject == $testObject
    );

    var_dump(
        '$mockInstance type matches $testObject type',
        $mockInstance::class === $testObject::class
    );

    file_put_contents(
        '/tmp/darlingTestJson.json',
        PHP_EOL . $testJson->__toString()
    );
} else {
    var_dump('Failed to decode object', $decodedTestObject);
}
