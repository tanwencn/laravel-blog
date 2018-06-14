<?php
/**
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2017/10/12 11:02
 */

namespace Tanwencn\Blog;

use Igaster\LaravelTheme\Facades\Theme;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Tanwencn\Blog\Consoles\InstallCommand;

class BlogServiceProvider extends ServiceProvider
{

    public function boot()
    {
        //$this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config' => config_path(),
                __DIR__ . '/../resources/assets' => public_path('vendor/laravel-blog'),
                __DIR__ . '/../resources/lang' => resource_path('lang'),
                __DIR__ . '/../database/migrations' => database_path('migrations'),
                __DIR__ . '/../database/seeds' => database_path('seeds'),
                __DIR__ . '/../widgets' => app_path('Widgets')
            ], 'blog');

            $this->commands([
                InstallCommand::class
            ]);
        } else {

            //config(['app.url' => option('web_url', 'http://localhost')]);

            //config(['app.name' => option('web_name', 'TanwenCms')]);
        }

        Theme::set(option('themes', 'default'));

        $this->app['view']->prependNamespace('pagination', Theme::current()->getViewPaths());

        $this->registerBlades();

    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->register(AdminServiceProvider::class);
    }

    protected function registerBlades()
    {
        Blade::directive('recursive', function ($expression) {
            return "<?php \$depth=0; \$recursive_data = {$expression}; \$recursive = function()use(&\$recursive){\$args = func_get_args(); \$data = array_shift(\$args); \$depth = array_shift(\$args);foreach (\$data as \$key => \$val):?>";
        });

        Blade::directive('nextrecursive', function ($expression) {
            if ($expression) {
                $arr = explode(',', $expression);
            }
            $results = "<?php if(!empty(\$val->children)): ?>";
            $results .= isset($arr[0]) ? $arr[0] : '';
            $results .= "<?php \$recursive(\$val->children, \$depth+1, ...\$args); ?>";
            $results .= isset($arr[1]) ? $arr[1] : '';
            $results .= "<?php endif; ?>";
            return $results;
        });

        Blade::directive('endrecursive', function ($expression) {
            return "<?php endforeach;};\$recursive(\$recursive_data, \$depth " . ($expression ? ',' . $expression : '') . ")?>";
        });
    }

}
