<?php
/**
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2017/10/12 11:02
 */

namespace Tanwencn\Blog;

use Illuminate\Support\ServiceProvider;
use Tanwencn\Blog\Foundation\Admin;
use Tanwencn\Blog\Foundation\AdminHelper;
use Tanwencn\Blog\Http\Middleware;
use Tanwencn\Blog\Database\Eloquent;
use Tanwencn\Blog\Widgets\DashboardLeftWidget;
use Tanwencn\Blog\Widgets\DashboardRightWidget;

class AdminServiceProvider extends ServiceProvider
{

    protected $routeMiddleware = [
        //'role' => Middleware\Role::class,
        //'curd' => Middleware\Curd::class
    ];

    protected $middlewareGroups = [
        'admin' => [
            'web',
            Middleware\Authenticate::class,
            Middleware\FilterIfPjax::class
        ]
    ];

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/admin.php');
        
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'admin');

        /*Relation::morphMap([
            Page::class => Page2::class
        ]);*/
        
        $this->registerMenus();

        $this->registerWidgets();

    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('admin', function ($app) {
            return new Admin($app['config'], $app['auth'], $app['router']);
        });
        
        $this->registerRouteMiddleware($this->app['router']);
    }

    protected function registerRouteMiddleware($router)
    {
        foreach ($this->middlewareGroups as $key => $middleware) {
            $router->middlewareGroup($key, $middleware);
        }

        foreach ($this->routeMiddleware as $key => $middleware) {
            $router->aliasMiddleware($key, $middleware);
        }
    }

    protected function registerMenus()
    {
        \Admin::menu()->define(trans('admin.dashboard'), [
            'icon' => 'fa-dashboard',
            'uri' => '/',
            'authority' => 'view_dashboard'
        ]);
        \Admin::menu()->define(trans_choice('admin.role', 0), [
            'uri' => 'roles',
            'icon' => 'fa-lock',
            'authority' => 'view_role'
        ]);
        \Admin::menu()->define(trans_choice('admin.user', 0), [
            'icon' => 'fa-user',
            'uri' => 'users',
            'authority' => 'view_user'
        ]);

        \Admin::menu()->define(trans_choice('admin.page', 0), [
            'icon' => 'fa-file-powerpoint-o',
            'uri' => 'pages',
            'authority' => 'view_page'
        ]);

        $posts_title = trans('admin.posts');
        \Admin::menu()->define($posts_title, [
            'icon' => 'fa-edit'
        ]);
        \Admin::menu()->define(trans_choice('admin.all_posts', 0), [
            'uri' => 'posts',
            'authority' => 'view_posts'
        ], $posts_title);
        \Admin::menu()->define(trans_choice('admin.add_posts', 0), [
            'uri' => 'posts/create',
            'authority' => 'add_posts'
        ], $posts_title);
        \Admin::menu()->define(trans_choice('admin.category', 0), [
            'uri' => 'categories',
            'authority' => 'view_category'
        ], $posts_title);
        \Admin::menu()->define(trans_choice('admin.tag', 0), [
            'uri' => 'tags',
            'authority' => 'view_tag'
        ], $posts_title);

        \Admin::menu()->define(trans_choice('admin.menu', 0), [
            'icon' => 'fa-navicon',
            'uri' => 'menus/create',
            'authority' => 'view_menu'
        ]);
        \Admin::menu()->define(trans_choice('admin.advertising', 0), [
            'icon' => 'fa-buysellads',
            'uri' => 'adv',
            'authority' => 'view_advertising'
        ]);

        \Admin::menu()->define(trans_choice('admin.setting', 0), [
            'icon' => 'fa-cog',
            'uri' => 'options/general',
            'authority' => 'general_settings'
        ]);
    }

    protected function registerWidgets(){
        /*Admin::addMenuSide(trans('admin.page'), Models\Page::class, 1);
        Admin::addMenuSide(trans('admin.posts_category'), Models\PostsCategory::class, 10);
        Admin::addMenuSide(trans('admin.posts'), Models\Posts::class, 20);
        Admin::addDashboardLeft(DashboardLeftWidget::class);
        Admin::addDashboardRight(DashboardRightWidget::class);*/
    }
}
