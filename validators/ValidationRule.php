<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/5/2023
 * Time: 11:41 AM
 */

namespace roshangiga;

interface ValidationRule {
    public function validate($value);
    public function getErrorMessage($field);
}