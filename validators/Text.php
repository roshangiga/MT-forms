<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/5/2023
 * Time: 11:43 AM
 */

namespace roshangiga;

/**
 * Validates that a value contains only alphanumeric characters, spaces, and symbols.
 */
class text implements ValidationRule
{

    public function validate($value)
    {
        return isset($value) && preg_match('/^[\p{L}\p{Zs}\p{P}\p{S}]+$/u', $value);
    }

    public function getErrorMessage($field)
    {
        return "$field must contains only alphanumeric characters, spaces,, punctuation and symbols";
    }
}