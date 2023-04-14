<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/13/2023
 * Time: 3:50 PM
 */
namespace roshangiga;

Class Utils {
    public static function minify_css($css) {
        // Remove comments
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);

        // Remove space after colons
        $css = str_replace(': ', ':', $css);

        // Remove whitespace
        $css = str_replace(["\r\n", "\r", "\n", "\t", '  ', '    ', '    '], '', $css);

        return $css;
    }

}
