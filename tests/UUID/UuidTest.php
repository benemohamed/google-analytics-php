<?php
namespace benemohamed\analytics\tests\UUID;

use benemohamed\analytics\UUID\Uuid;

use PHPUnit\Framework\TestCase;

/**
 * Uuid
 * @package benemohamed\analytics\tests\UUI
 */
class UuidTest extends TestCase
{
    public function test_regex()
    {
        self::assertRegExp('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?'.
            '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', '00b0b789-9789-42c4-bfa5-d6691048df48', 'Change pattern '); // check with regex if valid string look like(00b0b789-9789-42c4-bfa5-d6691048df48)


    }

    public function test_not_null()
    {

        self::assertNotNull(UUID::v4(), 'Error');

    }
}
