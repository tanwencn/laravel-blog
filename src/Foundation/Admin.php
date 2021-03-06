<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2017/10/12 11:02
 */

namespace Tanwencn\Blog\Foundation;

use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Routing\Router;
use BadMethodCallException;

class Admin
{

    private $config;

    private $auth;

    private $instances;

    public function __construct(Repository $config, AuthManager $auth, Router $router)
    {
        $this->config = $config;
        $this->auth = $auth;
        $this->router = $router;
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

    public function dashboard($widget, $config = [], $position = 100)
    {
        \Widget::group('admin_dashboard')->position($position)->addWidget($widget, $config);
    }

    public function __call($name, $arguments)
    {
        $class = str_start(__NAMESPACE__ . str_start(studly_case($name), '\\'), '\\');

        if (isset($this->instances[$class])) return $this->instances[$class];

        if (class_exists($class)) {
            $this->instances[$class] = app($class);
            return $this->instances[$class];
        }

        throw new BadMethodCallException("Method {$name} does not exist.");
    }
}
