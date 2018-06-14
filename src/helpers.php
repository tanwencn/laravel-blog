<?php
use \Tanwencn\Blog\Database\Eloquent;
use \Illuminate\Support\HtmlString;


if (!function_exists('option')) {
    function option($name, $default = '')
    {
        return Eloquent\Option::byName($name, $default);
    }
}
if (!function_exists('comments_target')) {
    function comments_target($model)
    {
        return new HtmlString('<input type="hidden" name="target_id" value="'.$model->id.'"><input type="hidden" name="target_model" value="'.get_class($model).'">');
    }
}
