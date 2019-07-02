<?php
namespace benemohamed\analytics\tests\Analytics;

use benemohamed\analytics\Analytics;
use benemohamed\analytics\Validation\TrackingIdvalidation;
use benemohamed\analytics\Validation\HitTypevalidation;
use benemohamed\analytics\Exception\AnalyticsException;
use benemohamed\analytics\UUID\Uuid;
use ipfinder\ipfinder\IPfinder;

use PHPUnit\Framework\TestCase;

/**
 *  Analytics
 * @package benemohamed\analytics\tests\Analytics
 */
class AnalyticsTest extends TestCase
{

    public function test_construct()
    {
          $trackingId = 'UA-101958632-2';
          $test = new Analytics('UA-101958632-2',null);
          $this->assertSame($trackingId, $test->trackingId);
          $this->assertSame(null, $test->ipfinder_apitoken);
    }

    public function test_construct_Exception()
    {
          $this->expectException(AnalyticsException::class);
          $this->expectExceptionMessage('Invalid Analytics tracking');
          $test = new Analytics('UA-',null);


          $this->expectException(AnalyticsException::class);
          $this->expectExceptionMessage('trackingId required Example value: UA-XXXX-Y');
          $test2 = new Analytics('',null);
    }

    public function testvar()
    {
          $test = new Analytics('UA-101958632-2','asdddddddddddddddddddddddddddddddddddddddd');
          $this->assertNotNull($test->ipfinder_apitoken, 'IS NULL CHECK YOUR VAR');
          $this->assertNotNull($test->trackingId, 'IS NULLCHECK YOUR VAR');
          $this->assertNull($test->agent, 'NOT NULLCHECK YOUR VAR');
          $this->assertNull($test->ip, 'NOT NULLCHECK YOUR VAR');
          $this->assertNull($test->data_source, 'NOT NULLCHECK YOUR VAR');
          $this->assertNull($test->hit, 'NOT NULLCHECK YOUR VAR');
          $this->assertNull($test->country_code, 'NOT NULLCHECK YOUR VAR');
          $this->assertNull($test->session, 'NOT NULLCHECK YOUR VAR');
          $this->assertNull($test->Uuid_v4, 'NOT NULLCHECK YOUR VAR');
          $this->assertNull($test->host, 'NOT NULLCHECK YOUR VAR');
          $this->assertNull($test->path, 'NOT NULLCHECK YOUR VAR');
          $this->assertNull($test->title, 'NOT NULLCHECK YOUR VAR');
          $this->assertNull($test->event_tracking, 'NOT NULLCHECK YOUR VAR');
          $this->assertNull($test->event_action, 'NOT NULLCHECK YOUR VAR');
          $this->assertNull($test->event_label, 'NOT NULLCHECK YOUR VAR');
          $this->assertNull($test->payload_data, 'NOT NULLCHECK YOUR VAR');
          $this->assertNull($test->payload_query, 'NOT NULLCHECK YOUR VAR');
          $this->assertNull($test->parms, 'NOT NULLCHECK YOUR VAR');
    }
}
