<?php

namespace Darling\PHPJsonUtilities\tests\dev\test\classes;

use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPReflectionUtilities\classes\utilities\ObjectReflection;
use \Closure;
use \Iterator;
use \ReflectionClass;

class TestClassCoversMultipleEdgeCases {

    /**
     * Create a new instance.
     *
     * @param string $foo
     * @param ObjectReflection $objectReflection
     * @param Json $json
     * @param Id $id
     * @param Closure $closure
     * param Iterator $iterator # currently fails because a MockClassInstance cannot mock a class that expects an implementation of PHP's Iterator interface | re-enable once this issue is resolved
     * @param array<mixed> $array
     *
     */
    public function __construct(
        private readonly string $foo,
        private ObjectReflection $objectReflection,
        protected Json $json,
        public Id $id,
        public readonly Closure $closure,
        # public Iterator $iterator, # currently fails because a MockClassInstance cannot mock a class that expects an implementation of PHP's Iterator interface | re-enable once this issue is resolved
        public array $array = [],
    ) {
        for($i = 0; $i < 5; $i++) {
            $this->json = new Json($this->json);
        }
    }

    public function foo(): string
    {
        return $this->foo;
    }

    public function objectReflection(): ObjectReflection
    {
        return $this->objectReflection;
    }

    public function json(): Json
    {
        return $this->json;
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function closure(): Closure
    {
        return $this->closure;
    }

    /* # currently fails because a MockClassInstance cannot mock a class that expects an implementation of PHP's Iterator interface | re-enable once this issue is resolved
    public function iterator(): Iterator
    {
        return $this->iterator;
    }
     */

    /**
     * Return the ReflectionClass instance assigned to the this
     * instances ObjectReflection.
     *
     * @return ReflectionClass<object>
     *
     */
    public function reflectionClass(): ReflectionClass
    {
        return $this->objectReflection->reflectionClass();
    }
}

