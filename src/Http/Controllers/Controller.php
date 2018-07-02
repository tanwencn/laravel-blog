<?php
/**
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/6/7 下午7:13
 */

namespace Tanwencn\Blog\Http\Controllers;

use Tanwencn\Blog\Facades\Admin;
use Tanwencn\Blog\Http\Requests\Authorizes;

class Controller extends \Illuminate\Routing\Controller
{
    use Authorizes;

    protected function view($view, $data = [], $mergData = [])
    {
        return Admin::view(str_plural(str_before(strtolower(class_basename(static::class)), 'controller')) . '.' . $view, $data, $mergData);
    }

    public function authorize($ability, $arguments = [])
    {
        $ability = str_start($ability, 'admin.');
        list($ability, $arguments) = $this->parseAbilityAndArguments($ability, $arguments);

        return app(Gate::class)->authorize($ability, $arguments);
    }
}