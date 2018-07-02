<?php

namespace Tanwencn\Blog\Consoles;

use Illuminate\Console\Command;
use Tanwencn\Blog\BlogServiceProvider;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Blog';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('key:generate');
        $this->call('storage:link');

        $this->call('vendor:publish', [
            '--provider' => BlogServiceProvider::class
        ]);
        /*$this->call('vendor:publish', [
            '--provider' => PermissionServiceProvider::class,
            '--tag' => 'migrations'
        ]);*/
        $this->call('migrate');

        $this->info('Attempting to set User model as parent to App\User');
        if (file_exists(app_path('User.php'))) {
            $str = file_get_contents(app_path('User.php'));

            if ($str !== false) {
                $str = str_replace('extends Authenticatable', "extends \Tanwencn\Blog\Database\Eloquent\User", $str);

                file_put_contents(app_path('User.php'), $str);
            }
        } else {
            $this->warn('Unable to locate "app/User.php".  Did you move this file?');
            $this->warn('You will need to update this manually.  Change "extends Authenticatable" to "extends \Tanwencn\Blog\Database\Eloquent\User" in your User model');
        }

        $this->call('blog:registerPermissions');
    }
}
