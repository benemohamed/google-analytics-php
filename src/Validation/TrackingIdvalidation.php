<?php
namespace benemohamed\analytics\Validation;

use benemohamed\analytics\Exception\AnalyticsException;

/**
 *  class Tracking Id
 */
class TrackingIdvalidation implements ValidationInterface
{

    /**
     * Helper method for validate Google Analytics hits type
     *
     * @param  $argument     mixed The object to be validated
     * @return bool
     */
    public static function validate($argument)
    {
        if (!filter_var($argument, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^UA-\d{4,9}-\d{1,4}$/")))) {
            throw new AnalyticsException("Invalid Analytics tracking");
        }
        return true;
    }
}
