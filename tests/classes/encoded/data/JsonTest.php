<?php

namespace Darling\PHPJsonUtilities\tests\classes\encoded\data;

use \Darling\PHPJsonUtilities\classes\encoded\data\Json;
use \Darling\PHPJsonUtilities\tests\PHPJsonUtilitiesTest;
use \Darling\PHPJsonUtilities\tests\interfaces\encoded\data\JsonTestTrait;

class JsonTest extends PHPJsonUtilitiesTest
{

    public const CLASS_INDEX = '__class__';

    public const DATA_INDEX = '__data__';

    /**
     * The JsonTestTrait defines common tests for implementations
     * of the Darling\PHPJsonUtilities\interfaces\encoded\data\Json
     * interface.
     *
     * @see JsonTestTrait
     *
     */
    use JsonTestTrait;

    public function setUp(): void
    {
        $data = $this->randomData();
        $this->setExpectedJsonString($data);
        $this->setJsonTestInstance(
            new Json($data)
        );
    }

}

