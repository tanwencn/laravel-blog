<?php

Route::prefix(config('admin.route.prefix', 'admin'))->group(function ($router) {

    $router->middleware('web')->namespace('Tanwencn\Blog\Http\Controllers')->group(function ($router) {
        $router->get('login', 'LoginController@showLoginForm')->name('admin.login');
        $router->post('login', 'LoginController@login')->name('admin.login');
        $router->get('logout', 'LoginController@logout')->name('admin.logout');
    });


    $router->middleware(['admin'])->group(function ($router) {
        $router->namespace('Tanwencn\Blog\Elfinder')->group(function ($router) {
            $router->any('elfinder/connector', ['as' => 'elfinder.connector', 'uses' => 'ElfinderController@showConnector']);
            $router->get('elfinder/popup/{input_id}', ['as' => 'admin.elfinder.popup', 'uses' => 'ElfinderController@showPopup']);
        });
        $router->namespace('Tanwencn\Blog\Http\Controllers')->group(function ($router) {

            $router->get('/', 'DashboardController@index')->name('admin.dashboard');

            $router->resource('users', 'UserController')->names('admin.users');;

            $router->resource('roles', 'RoleController')->names('admin.roles');

            $router->resource('pages', 'PageController')->names('admin.pages');

            $router->resource('posts', 'PostController')->names('admin.post');
            
            $router->resource('comments', 'CommentController')->names('admin.comments');

            $router->resource('categories', 'CategoryController')->names('admin.categories');

            $router->post('categories/order', 'CategoryController@order')->name('admin.categories.order');

            $router->resource('tags', 'TagController')->names('admin.tags');

            $router->resource('menus', 'MenuController')->names('admin.menus');;

            $router->resource('adv', 'AdvertisingController')->names('admin.advs');;

            $router->get('options/general', 'OptionController@general')->name('admin.options.general');

            $router->post('options/general', 'OptionController@general_store');


        });

        if (file_exists(base_path('routes/admin.php'))) {
            $router->group(base_path('routes/admin.php'));
        }

    });

});
