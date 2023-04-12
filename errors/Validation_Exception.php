<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/12/2023
 * Time: 11:11 AM
 */
namespace roshangiga;

class Validation_Exception extends \Exception {
    private $errors;

    public function __construct($message, $errors) {
        $this->errors = $errors;
        parent::__construct($message);
    }

    public function get_errors() {
        return $this->errors;
    }
}