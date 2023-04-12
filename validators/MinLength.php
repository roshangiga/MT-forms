<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/5/2023
 * Time: 11:59 AM
 */

namespace roshangiga;

/**
 * Validates that the input has a minimum length.
 */
class MinLength implements ValidationRule
{
    private $min;


    public function __construct($params = [])
    {
        $this->min = $params[0];
    }


    public function validate($input)
    {
        return (strlen($input) >= $this->min);
    }


    public function getErrorMessage($field)
    {
        return "$field must be at least {$this->min} characters long";
    }
}