<?php
/**
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2017/10/12 11:02
 */

namespace Tanwencn\Blog\Foundation;

use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Routing\Router;

class Admin
{
    private $menu;

    private $config;

    private $auth;

    private $menuSideNames;

    public function __construct(Repository $config, AuthManager $auth, Router $router)
    {
        $this->config = $config;
        $this->auth = $auth;
        $this->router = $router;
    }

    public function addDashboardLeft($widget, $config = [], $position = 100)
    {
        Widget::group('admin_dashboard_left')->position($position)->addWidget($widget, $config);
    }

    public function addDashboardRight($widget, $config = [], $position = 100)
    {
        Widget::group('admin_dashboard_right')->position($position)->addWidget($widget, $config);
    }

    public function addCss($content, $position = 100, $is_file = true)
    {
        Widget::group('admin_css')->position($position)->addWidget(AssetWidget::class, ['is_file' => $is_file], 'css', $content);
    }

    public function addJs($content, $position = 100, $is_file = true)
    {
        Widget::group('admin_js')->position($position)->addWidget(AssetWidget::class, ['is_file' => $is_file], 'js', $content);
    }

    public function addMenuSide($title, $class, $position = 100, $option = [])
    {
        $this->menuSideNames[$class] = $title;
        Widget::group('admin_menu_sides')->position($position)->addWidget(MenuSideWidget::class, $option, $title, $class);
    }

    public function getMenuSideNames($class = null)
    {
        if (is_null($class)) {
            return $this->menuSideNames;
        } else {
            return isset($this->menuSideNames[$class]) ? $this->menuSideNames[$class] : null;
        }
    }

    public function menu()
    {
        if (is_null($this->menu)) {
            $this->menu = new Menu($this->auth, $this->config->get('admin.route.prefix', 'admin'));
        }

        return $this->menu;
    }

    public function action($action, $parms = [])
    {
        if ($action == 'form') {
            return !empty($parms) ? $this->action('update', $parms) : $this->action('store');
        }
        $controller = str_before($this->router->current()->getActionName(), '@');
        return action(str_start($controller, '\\') . '@' . $action, $parms);
    }

    public function router()
    {
        return $this->router->prefix($this->config->get('admin.route.prefix', 'admin'));
    }

    public function view($view = null, $data = [], $mergData = [])
    {
        return view("admin::{$view}", $data, $mergData);
    }
}
