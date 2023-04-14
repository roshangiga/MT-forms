<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/13/2023
 * Time: 11:54 AM
 */

namespace roshangiga;

class Date extends BaseElement
{

    public function render()
    {
        $html = '';

        //get getHtmlLabel from parent
        $html .= $this->getHtmlLabel();

        $html .= '<input type="date" value="' . htmlspecialchars($this->value, ENT_QUOTES, 'UTF-8') . '"';
        foreach ($this->attributes as $attribute => $value) {
            if (!empty($value)) {
                $html .= ' ' . $attribute . '="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '"';
            }
        }
        $html .= '>';

        return $html;
    }
}