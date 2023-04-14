<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/13/2023
 * Time: 12:07 PM
 */

namespace roshangiga;

class File extends BaseElement
{
    private $file;
    private $deleteButtonId;

    public function __construct($attributes, $form_id, $file = null)
    {
        parent::__construct($attributes, $form_id);
        $this->file = $file;
        $this->deleteButtonId = $this->attributes['id'] . '-delete-button';
    }

    public function render()
    {
        $html = '';

        //get getHtmlLabel from parent
        $html .= $this->getHtmlLabel();

        $html .= '<input type="file" name="' . htmlspecialchars($this->value, ENT_QUOTES, 'UTF-8') . '"';
        foreach ($this->attributes as $attribute => $value) {
            if (!empty($value)) {
                $html .= ' ' . $attribute . '="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '"';
            }
        }
        $html .= '>';

        if ($this->file) {
            $html .= '<div></div>';
            $html .= '<div class="file-preview" style="display: flex; align-items: center; margin-top: 10px;">';
            $html .= '<div class="file-thumbnail-wrapper" style="flex: 0 0 auto; margin-right: 10px;">';
            $html .= '<img src="' . htmlspecialchars($this->file['url'], ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($this->file['name'], ENT_QUOTES, 'UTF-8') . '" class="file-thumbnail" style="max-width: 100px; max-height: 100px; object-fit: contain;">';
            $html .= '</div>';
            $html .= '<div class="file-name-wrapper" style="flex: 1 1 auto; position: relative;">';
            $html .= '<span class="file-name">' . htmlspecialchars($this->file['name'], ENT_QUOTES, 'UTF-8') . '</span>';

            if ($this->deleteButtonId) {
                $html .= '<button type="button" id="' . htmlspecialchars($this->deleteButtonId, ENT_QUOTES, 'UTF-8') . '" class="delete-file-button" style="position: absolute; top: 50%; right: 0; background-color: rgba(255, 0, 0, 0.5); border: none; color: #fff; font-size: 14px; cursor: pointer; transform: translateY(-50%);">x</button>';
            }

            $html .= '</div>';
            $html .= '</div>';
        }

        return $html;
    }
}