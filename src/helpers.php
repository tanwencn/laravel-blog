<?php
use \Tanwencn\Blog\Database\Eloquent;


if (!function_exists('option')) {
    function option($name, $default = '')
    {
        return Eloquent\Option::findByName($name, $default);
    }
}
