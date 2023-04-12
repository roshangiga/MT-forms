<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/5/2023
 * Time: 11:59 AM
 */

namespace roshangiga;

/**
 * Validates Mauritian phone number. Only checks for the format, not the validity of the number.
 * E.g. 6270000 OR +2306270000
 */
class Phone implements ValidationRule
{

    public function validate($value)
    {
        //remove all spaces and dashes from the value
        $value = str_replace(' ', '', $value);
        $value = str_replace('-', '', $value);

        return preg_match('/^\d{7}$|^[+230]\d{10}$/', $value);

    }


    public function getErrorMessage($field)
    {
        return "$field must be a valid phone number";
    }
}