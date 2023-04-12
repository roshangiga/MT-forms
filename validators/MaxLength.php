<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/5/2023
 * Time: 11:41 AM
 */

namespace roshangiga;

/**
 *
 * Validates that the input has a maximum length.
 */
class MaxLength implements ValidationRule
{
    private $max;

    /**
     * Validates that the input has a maximum length.
     * @param array $params
     */
    public function __construct($params = [])
    {
        $this->max = $params[0];
    }

    public function validate($value)
    {
        return (strlen($value) <= $this->max);
    }


    public function getErrorMessage($field)
    {
        return "$field must be no longer than {$this->max} characters";
    }
}