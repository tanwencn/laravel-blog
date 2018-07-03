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

    /**
     * Menu constructor.
     * @param AuthManager $auth
     */
    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
        $this->uri_prefix = config('admin.route.prefix', 'admin');
    }

    /**
     * define menu
     * @param $name
     * @param array $parameters
     * @param null|array|string $parent
     * @param null|array $children
     */
    public function define($name, $parameters = [], $parent = null, $children = [])
    {
        if (is_array($parent)) {
            $children = $parent;
            $parent = null;
        }
        if ($parent) {
            if (!array_has($this->items, $parent))
                throw new InvalidArgumentException("{$parent} does not exist");

            $name = "{$parent}.children.{$name}";

            if (empty($parameters['icon'])) $parameters['icon'] = 'fa-circle-o';
        } else {
            if (empty($parameters['icon'])) $parameters['icon'] = '';
        }
        if (empty($parameters['sort'])) $parameters['sort'] = 10;

        array_set($this->items, $name, $parameters);

        foreach ($children as $childName => $child) {
            $this->define($childName, $child, $name);
        }
    }

    /**
     * Menu parser
     * @param $items
     * @return static
     */
    protected function parser($items)
    {
        return collect($items)->sortBy('sort')->map(function ($val, $name) {

            $children = $this->parser(array_get($val, 'children'));

            $url = array_get($val, 'url', array_get($val, 'uri') ? url($this->uri_prefix . '/' . array_get($val, 'uri')) : '');

            return collect(array_merge($val, [
                'name' => $name,
                'url' => $url,
                'children' => $children->isNotEmpty() ? $children : null
            ]))->filter();

        })->filter(function ($val) {

            if (!$val->has('children') && !$val->has('url')) return false;

            $user = $this->auth->user();
            $authority = array_get($val, 'authority');

            return !empty($val['name']) && (!$authority || $user->can($authority));

        });
    }

    /**
     * render
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        return view('admin::menu', [
            'items' => $this->parser($this->items)
        ]);
    }
}