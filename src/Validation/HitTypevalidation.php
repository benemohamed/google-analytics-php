<?php
namespace benemohamed\analytics\Validation;

use benemohamed\analytics\Exception\AnalyticsException;

/**
 *  class Hit Type
 */
class HitTypevalidation implements ValidationInterface
{

    /**
     * Helper method for validating list hit type
     *
     * @param $argument     mixed The object to be validated
     * @return bool
     */
    public static function validate($argument)
    {
        if (!filter_var($argument, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^(pageview|event|screenview|transaction|item|social|exception|timing)$/")))) {
            throw new AnalyticsException("Invalid Google Analytics hits type");
        }
        return true;
    }
}
