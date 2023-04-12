<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/5/2023
 * Time: 11:54 AM
 */

namespace roshangiga;

/**
 * Validates that the input is a valid email address.
 */
class Email implements ValidationRule {

    public function validate($value) {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }


    public function getErrorMessage($field) {
        return "$field must be a valid email address";
    }
}