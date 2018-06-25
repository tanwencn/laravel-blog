<?php

namespace Tanwencn\Blog\Consoles;

use Illuminate\Console\Command;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Contracts\Role;
use Tanwencn\Blog\Database\Eloquent\User;

class BootPermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:registerPermissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register Permissions';

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
        //$this->info('Start to initialize permissions');
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $this->ability('dashboard');

        $this->ability('general_settings');

        $this->abilityResources('user');

        $this->abilityResources('role');

        $this->abilityResources('page');

        $this->abilityResources('post');

        $this->abilityResources('category');

        $this->abilityResources('tag');

        $this->abilityResources('advertising');

        $this->ability('menu');

        $this->ability('view_comment');

        $this->ability('edit_comment');

        $this->ability('delete_comment');

        $roleClass = app(Role::class);

        $roleClass::findOrCreate('superadmin');

        if (User::count() == 0) {
            $user = User::create([
                'name'           => 'Administor',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('admin')
            ]);
            $user->assignRole('superadmin');
        }

        $this->info('Initialize permissions is complete');
    }

    private function ability($name)
    {
        $permissionClass = app(Permission::class);

        $permissionClass::findOrCreate($name);
    }

    private function abilityResources($name)
    {
        $name = snake_case(class_basename($name));

        $abilitys = [
            'view',
            'add',
            'edit',
            'delete'
        ];
        foreach ($abilitys as $ability) {
            $this->ability($ability . '_' . $name);
        }
    }
}