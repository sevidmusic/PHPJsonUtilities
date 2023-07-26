<?php

namespace Darling\PHPJsonUtilities\tests\dev\test\classes;

use \Darling\PHPTextTypes\classes\strings\Id;
use \Darling\PHPJsonUtilities\classes\encoded\data\Json;

/**
 * This class is used by tests defined by the PHPJsonUtilities library.
 *
 * It should not be used in any other context.
 *
 */
final class ClassDefinesPropertiesThatMayBeAssignedAJsonInstanceThatContainsNestedJsonInstances
{

    /** @var array<Id> */
    private array $ids;

    public function __construct(
        private Json $json,
        Id ...$ids
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
