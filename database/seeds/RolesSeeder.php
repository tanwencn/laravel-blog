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
        $this->addAbility('view_dashboard');

        $this->addAbility('general_settings');

        $this->addAbilitys(Models\User::class);

        $this->addAbilitys('role');

        $this->addAbilitys(Models\Page::class);

        $this->addAbilitys(Models\Posts::class);

        $this->addAbilitys('category');

        $this->addAbilitys('tag');

        $this->addAbilitys('menu');

        $this->addAbilitys('advertising');

        Role::create(['name' => 'writer'])
    }

    private function addAbilitys($name)
    {
        $name = snake_case(class_basename($name));

        foreach ($this->abilities as $ability){
            $this->addAbility($ability.'_'.$name);
        }
    }

    protected function addAbility($name)
    {

        Permission::create([
            'name' => $name
        ]);

    }
}
