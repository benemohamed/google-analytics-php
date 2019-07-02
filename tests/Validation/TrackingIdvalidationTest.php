<?php
namespace benemohamed\analytics\tests\Validation;

use benemohamed\analytics\Validation\TrackingIdvalidation;
use benemohamed\analytics\Exception\AnalyticsException;

use PHPUnit\Framework\TestCase;

/**
 * TrackingIdvalidation
 * @package benemohamed\analytics\tests\Validation
 */
class TrackingIdvalidationTest extends TestCase
{
    public static function positiveProvider()
    {
        return array(
            array("UA-101958632-2"),
            array("UA-701958633-2"),
            array("UA-601958634-2"),
            array("UA-301958635-2"),
            array("UA-201958636-2"),
            array("UA-001958637-2"),
            array("UA-501958638-2"),
            array("UA-101959639-2")
        );
    }

    public static function invalidProvider()
    {
        return array(
            array("ua-101958632-2"),
            array("541477784"),
            array("sadwfsdgfdg"),
            array("65415874874")
        );
    }

    /**
     *
     * @dataProvider positiveProvider
     */
    public function testValidate($input)
    {
        $this->assertTrue(TrackingIdvalidation::validate($input, "test hits"));
    }
    /**
     *
     * @dataProvider invalidProvider
     */

    public function testValidateException($input)
    {
        $this->expectException(AnalyticsException::class);
        $this->expectExceptionMessage('Invalid Analytics tracking');
        TrackingIdvalidation::validate($input, "test hits");
    }


}
