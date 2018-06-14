<?php

namespace Tanwencn\Blog\Consoles;

use Encore\Admin\Admin;
use Illuminate\Console\Command;
use Tanwencn\Blog\CmsServiceProvider;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tanwencms:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install tanwencms';

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
            '--tag' => "tanwencms"
        ]);
        $this->call(' migrate:install');
        $this->call(' db:seed');

        /*retry(5, function () {
            throw_if(config('admin.database.users_table')!='admin_users_', 'aa');
        }, 1000);
        var_dump(config('admin.database.users_table')=='admin_user_');
        ;exit;*/

        /*$this->call('admin:install');
        foreach (Admin::$extensions as $key => $extension){
            $this->call('admin:import', ['extension' => $key]);
        }*/
    }
}
