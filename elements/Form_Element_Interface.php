<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/12/2023
 * Time: 10:57 AM
 */
namespace roshangiga;
interface Form_Element_Interface {
    public function __construct($attributes, $form_id);
    public function render();
}