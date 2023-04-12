<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/12/2023
 * Time: 10:56 AM
 */

spl_autoload_register(function ($class) {
    $prefix = 'roshangiga\\';
    $base_dirs = array(
        __DIR__ . '/elements/',
        __DIR__ . '/errors/',
        __DIR__ . '/validators/',
    );

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $relative_path  = str_replace('\\', '/', $relative_class) . '.php';

    foreach ($base_dirs as $base_dir) {
        $file = $base_dir . $relative_path;
        if (file_exists($file)) {
            require $file;
            break;
        }
    }
});