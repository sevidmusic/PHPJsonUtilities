<?php

namespace Darling\PHPJsonUtilities\tests\dev\test\classes;

use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPTextTypes\classes\strings\Name;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json;

class TestClassThatDefinesAPropertyThatAcceptsAJsonInstance {
    /** @var array<Id> */
    private array $ids;
    public function __construct(
        private \Darling\PHPJsonUtilities\classes\encoded\data\Json $json,
        \Darling\PHPTextTypes\classes\strings\Id ...$ids
    ) {
        foreach($ids as $id) {
            $this->ids[] = $id;
        }
    }

    public function json(): Json
    {
        return $this->json;
    }

    /** @return array<Id> */
    public function ids(): array
    {
        return $this->ids;
    }

}
