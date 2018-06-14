<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User();
        $user->fill([
            'email' => 'admin@admin.com',
            'name' => 'Administor',
            'password' => bcrypt('admin')
        ]);
        $user->id = 1;
        $user->save();

        Bouncer::assign('superadmin')->to($user);
    }
}
