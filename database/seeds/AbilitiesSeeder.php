<?php

use Illuminate\Database\Seeder;
use \Tanwencn\Blog\Database\Eloquent;
use Silber\Bouncer\BouncerFacade as Bouncer;

class AbilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bouncer::allow('superadmin')->everything([
            'title' => trans('admin.all_abilities')
        ]);

        $this->addAbility('dashboard');

        $this->addAbility('general_settings', Models\Option::class);

        $this->addCurd(Models\User::class);

        $this->addCurd(\Silber\Bouncer\Database\Role::class);

        $this->addCurd(Models\Page::class);

        $this->addCurd(Models\Posts::class);

        $this->addCurd(Models\PostsCategory::class, 'category');

        $this->addCurd(Models\PostsTag::class, 'tag');

        //$this->addCurd(Models\Menu::class);

        $this->addAbility('menus_manage', ['menu']);

        $this->addAbility('advertising_manage', ['advertising']);

        //$this->addCurd(Models\Advertising::class);
    }

    protected function addCurd($model_name, $title=null)
    {
        $name = $title?:snake_case(class_basename($model_name));

        $this->addAbility('index', [$name], $model_name);

        $this->addAbility('add', "add_{$name}", $model_name);

        $this->addAbility('edit', "edit_{$name}", $model_name);

        $this->addAbility('delete', "delete_{$name}", $model_name);
    }

    protected function addAbility($name, $title = null, $type = null)
    {
        if(!$title)
            $title = $name;

        Bouncer::ability()->create([
            'name' => $name,
            'title' => is_array($title) ? trans_choice("admin.{$title[0]}", 0) : trans("admin.{$title}"),
            'entity_type' => $type
        ]);

    }
}
