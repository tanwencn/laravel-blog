<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/6/8 下午5:06
 */

namespace Tanwencn\Blog\Foundation;

use InvalidArgumentException;
use Illuminate\Auth\AuthManager;
use Tanwencn\Blog\Widgets\SideWidget;

class Side
{
    private $auth;

    private $names;

    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    public function add($title, $class, $authority = 'dashboard', $position = 10)
    {
        $this->names[$class] = $title;
        \Widget::group('admin_menu_sides')->position($position)->addWidget(SideWidget::class, [], $title, $class);
    }

    public function names($class = null)
    {
        if (is_null($class)) {
            return $this->names;
        } else {
            return isset($this->names[$class]) ? $this->names[$class] : null;
        }
    }
}