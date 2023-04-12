<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/12/2023
 * Time: 10:58 AM
 */

namespace roshangiga;

class Input extends BaseElement
{

    public function render()
    {
        $html = '';

        if (!empty($this->label)) {
            $html .= '<label for="' . $this->attributes['id'] . '">' . $this->label . '</label>';
        }

        $html .= '<input';
        foreach ($this->attributes as $attribute => $value) {
            if (!empty($value)) {
                $html .= ' ' . $attribute . '="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '"';
            }
        }
        $html .= '>';

        return $html;
    }

}