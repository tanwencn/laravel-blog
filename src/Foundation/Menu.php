<?php
/**
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/6/8 下午5:06
 */

namespace Tanwencn\Blog\Foundation;

use InvalidArgumentException;
use Illuminate\Auth\AuthManager;

class Menu
{
    private $items;

    private $auth;

    private $uri_prefix;

    public function __construct(AuthManager $auth, $uri_prefix)
    {
        $this->auth = $auth;
        $this->uri_prefix = $uri_prefix;
    }

    public function define($name, $parameters = [], $parent = null)
    {
        if ($parent) {
            if (!array_has($this->items, $parent))
                throw new InvalidArgumentException("{$parent} does not exist");

            $name = "{$parent}.children.{$name}";

            if (empty($parameters['icon'])) $parameters['icon'] = 'fa-circle-o';
        } else {
            if (empty($parameters['icon'])) $parameters['icon'] = '';
        }

        array_set($this->items, $name, $parameters);
    }

    protected function parser($items)
    {
        return collect($items)->map(function ($val, $name) {

            $children = $this->parser(array_get($val, 'children'));

            $url = array_get($val, 'url', array_get($val, 'uri') ? url($this->uri_prefix.'/'.array_get($val, 'uri')) : '');

            return collect(array_merge($val, [
                'name' => $name,
                'url' => $url,
                'children' => $children->isNotEmpty() ? $children : null
            ]))->filter();

        })->filter(function ($val) {

            if (!$val->has('children') && !$val->has('url')) return false;

            $user = $this->auth->user();
            $authority = array_get($val, 'authority');

            return !empty($val['name']) && (!$authority || $user->hasRole('superadmin') || $user->hasPermissionTo($authority));

        });
    }

    public function render()
    {
        return view('admin::menu', [
            'items' => $this->parser($this->items)
        ]);
    }
}