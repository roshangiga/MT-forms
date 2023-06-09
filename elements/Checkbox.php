<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/12/2023
 * Time: 10:58 AM
 */

namespace roshangiga;

class Checkbox extends BaseElement
{

    public function __construct($attributes, $form_id)
    {
        parent::__construct($attributes, $form_id);

        // Set the default value for the checked attribute in addition to the default values of the parent class.
        $defaults = array(
            'checked' => '',
            'type'    => 'checkbox',
            'value'   => '1',
        );

        $this->attributes = array_merge($this->attributes, $defaults, $attributes);

    }


    public function render()
    {
        $html = '';

        //get getHtmlLabel from parent
        $html .= $this->getHtmlLabel();

        $html .= '<input type="checkbox" name="' . htmlspecialchars($this->name, ENT_QUOTES, 'UTF-8') . '" value="' . htmlspecialchars($this->value, ENT_QUOTES, 'UTF-8') . '"';
        foreach ($this->attributes as $attribute => $value) {
            if (!empty($value)) {
                $html .= ' ' . $attribute . '="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '"';
            }
        }
        $html .= '>';

        return $html;
    }

}