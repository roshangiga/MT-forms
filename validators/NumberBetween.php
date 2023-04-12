<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/5/2023
 * Time: 11:55 AM
 */

namespace roshangiga;

/**
 * Validates that the input is a number between a minimum and maximum value.
 */
class NumberBetween implements ValidationRule
{
    private $min;
    private $max;


    public function __construct($params = [])
    {
        $this->min = (int)$params[0];
        $this->max = (int)$params[1];
    }


    public function validate($value)
    {
        return ($value >= $this->min && $value <= $this->max);
    }


    public function getErrorMessage($field)
    {
        return "$field must be between {$this->min} and {$this->max}";
    }
}