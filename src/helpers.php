<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2017/10/12 11:02
 */

use \Tanwencn\Blog\Database\Eloquent;

if (!function_exists('option')) {
    function option($name, $default = '')
    {
        return Eloquent\Option::findByName($name, $default);
    }
}
