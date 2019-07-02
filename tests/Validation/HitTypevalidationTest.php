<?php
namespace benemohamed\analytics\tests\Validation;

use benemohamed\analytics\Validation\HitTypevalidation;
use benemohamed\analytics\Exception\AnalyticsException;

use PHPUnit\Framework\TestCase;

/**
 * HitTypevalidation
 * @package benemohamed\analytics\tests\Validation
 */
class HitTypevalidationTest extends TestCase
{
    public static function positiveProvider()
    {
        return array(
            array("pageview"),
            array("event"),
            array("screenview"),
            array("transaction"),
            array("item"),
            array("social"),
            array("exception"),
            array("timing")
        );
    }

    public static function invalidProvider()
    {
        return array(
            array("asdasd"),
            array("azxczx"),
            array("sadwfsdgfdg"),
            array("zczxcscadsa")
        );
    }

    /**
     *
     * @dataProvider positiveProvider
     */
    public function testValidate($input)
    {
        $this->assertTrue(HitTypevalidation::validate($input, "test hits"));
    }
    /**
     *
     * @dataProvider invalidProvider
     */

    public function testValidateException($input)
    {
        $this->expectException(AnalyticsException::class);
        $this->expectExceptionMessage('Invalid Google Analytics hits type');
        HitTypevalidation::validate($input, "test hits");
    }


}
