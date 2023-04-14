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
    public $is_required;
    public $form_id;

    public function __construct($attributes, $form_id)
    {
        $this->form_id = $form_id;

        $defaults = array(
            'id'          => !empty($attributes['name']) ? "{$attributes['name']}_$this->form_id" : '',
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

    /**
     * @param mixed $label
     */
    public function setLabel($label): void
    {
        $this->label = $label;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @param mixed $validation_rules
     */
    public function setValidationRules($validation_rules): void
    {
        $this->validation_rules = $validation_rules;

        //if $this->validation_rules contains Required, add required attribute
        if (strpos($this->validation_rules, 'Required') !== false) {
            $this->is_required = true;
        }
    }

    /**
     * @param mixed $form_id
     */
    public function setFormId($form_id): void
    {
        $this->form_id = $form_id;
    }

    /**
     * @return string
     */
    public function getHtmlLabel(): string
    {
        $html = '';
        $html_req = '';

        if ($this->is_required) {
            $html_req = ' <span class="required">*</span>';
        }

        if (!empty($this->label)) {
            $html .= '<label for="' . $this->attributes['id'] . '">' . $this->label . $html_req . '</label>';
        }
        return $html;
    }


    abstract public function render();
}
