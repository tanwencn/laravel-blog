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

        $this->call('vendor:publish');
        $this->call('migrate:install');
        $this->call('blog:registerPermissions');
    }
}
