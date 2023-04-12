<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/12/2023
 * Time: 8:01 PM
 */

namespace roshangiga;

/**
 * All other elements should extend this class.
 * It provides some universal attributes all elements should have.
 * render() method should be implemented by all children.
 */
abstract class BaseElement implements Form_Element_Interface
{
    public $label;
    public $value;
    public $attributes;
    public $validation_rules;
    public $form_id;

    public function __construct($attributes, $form_id)
    {
        $defaults = array(
            'id'          => !empty($attributes['name']) ? "{$attributes['name']}_{$this->form_id}" : '',
            'name'        => '',
            'type'        => 'text',
            'class'       => '',
            'value'       => '',
            'placeholder' => '',
            'readonly'    => '',
        );

        $this->attributes = array_merge($defaults, $attributes);

        if (isset($attributes['readonly'])) {
            $this->attributes['onclick'] = 'return false;';
        }
    }

    abstract public function render();
}
