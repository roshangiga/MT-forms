<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/13/2023
 * Time: 11:53 AM
 */

namespace roshangiga;

class Button extends BaseElement
{

    public function render()
    {
        $html = '<button';
        foreach ($this->attributes as $attribute => $value) {
            if (!empty($value)) {
                $html .= ' ' . $attribute . '="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '"';
            }
        }
        $html .= '>';

        if (!empty($this->label)) {
            $html .= $this->label;
        }

        $html .= '</button>';

        return $html;
    }
}