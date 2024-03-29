<?php

namespace Darling\PHPJsonUtilities\tests\dev\test\classes;

/**
 * This class is used by tests defined by the PHPJsonUtilities library.
 *
 * It should not be used in any other context.
 *
 */
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
