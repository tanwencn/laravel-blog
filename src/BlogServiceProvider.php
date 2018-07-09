<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2017/10/12 11:02
 */

namespace Tanwencn\Blog;

use Igaster\LaravelTheme\Facades\Theme;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Tanwencn\Blog\Consoles\InstallCommand;
use Tanwencn\Blog\Consoles\BootPermissionsCommand;

class BlogServiceProvider extends ServiceProvider
{

    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config' => config_path(),
                __DIR__ . '/../resources/assets' => public_path('vendor/laravel-blog'),
                __DIR__ . '/../resources/lang' => resource_path('lang'),
                __DIR__ . '/../database/migrations' => database_path('migrations')
            ], 'blog');

            $this->commands([
                InstallCommand::class,
                BootPermissionsCommand::class
            ]);
        }

        Theme::set(option('theme', 'default'));

        $viewPaths = Theme::current()->getViewPaths();

        if (isset($viewPaths[0]))
            $this->app['view']->prependNamespace('pagination', $viewPaths[0].'/pagination');

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
