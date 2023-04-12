<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/5/2023
 * Time: 11:57 AM
 */

namespace roshangiga;

/**
 * Validates that the input is greater than or equal to a minimum value.
 */
class MinValue implements ValidationRule
{
    private $min;

    /**
     * Validates that the input exceeds a minimum value.
     *
     */
    public function __construct($params = [])
    {
        $this->min = (int)$params[0];
    }


    public function validate($value)
    {
        return ($value >= $this->min);
    }


    public function getErrorMessage($field)
    {
        return "$field must be greater than or equal to {$this->min}";
    }
}