<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/5/2023
 * Time: 12:01 PM
 */

namespace roshangiga;

/**
 * Validates that the input is a valid URL.
 */
class URL implements ValidationRule
{

    public function validate($input)
    {
        return filter_var($input, FILTER_VALIDATE_URL);
    }

    /**
     * Returns the error message to display if the input is invalid.
     *
     * @return string The error message.
     */
    public function getErrorMessage($field)
    {
        return "$field must be a valid URL";
    }
}