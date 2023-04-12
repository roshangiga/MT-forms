<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/5/2023
 * Time: 12:39 PM
 */

namespace roshangiga;

/**
 * Validates that a value is present.
 */
class Required implements ValidationRule {

    public function validate($value) {
        return !empty($value);
    }

    public function getErrorMessage($field) {
        return "$field is required";
    }
}