<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Silber\Bouncer\Database\Role::created([
            'name' => 'superadmin',
            'title' => trans('admin.superadmin')
        ]);
    }
}
