<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/5/2023
 * Time: 12:04 PM
 */

namespace roshangiga;


use http\Params;

/**
 * Validates that the input is less than or equal to a maximum value.
 */
class MaxValue implements ValidationRule
{
    private $max;


    public function __construct($params = [])
    {
        $this->max = (int)$params[0];
    }


    public function validate($input)
    {
        return ($input <= $this->max);
    }


    public function getErrorMessage($field)
    {
        return "$field must be less than or equal to {$this->max}";
    }
}