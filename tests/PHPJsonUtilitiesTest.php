<?php

namespace PHPJsonUtilitiesTest\tests;

use Darling\PHPUnitTestUtilities\traits\PHPUnitConfigurationTests;
use Darling\PHPUnitTestUtilities\traits\PHPUnitRandomValues;
use Darling\PHPUnitTestUtilities\traits\PHPUnitTestMessages;
use PHPUnit\Framework\TestCase;

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
}

