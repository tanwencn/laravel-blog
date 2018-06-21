<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $this->ability('dashboard');

        $this->ability('general_settings');

        $this->abilityResources('user');

        $this->abilityResources('role');

        $this->abilityResources('page');

        $this->abilityResources('posts');

        $this->abilityResources('category');

        $this->abilityResources('tag');

        $this->abilityResources('menu');

        $this->abilityResources('advertising');

        $this->ability('view_comment');

        $this->ability('edit_comment');

        $this->ability('delete_comment');

        Role::findOrCreate('superadmin');

        Role::findOrCreate('general_user');

    }

    private function ability($name)
    {
        Permission::findOrCreate($name);
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
