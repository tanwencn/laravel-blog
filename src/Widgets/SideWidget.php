<?php

namespace Tanwencn\Blog\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Tanwencn\Blog\Database\Eloquent\Concerns\HasChildrens;

class SideWidget extends AbstractWidget
{

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run($name, $class)
    {
        if(in_array(HasChildrens::class, class_uses_recursive($class, 'tree'))){
            $data = $class::tree()->get();
        }else{
            $data = $class::all();
        }

        $class_name = class_basename($class);

        return view('admin::widgets.menu_setting', compact('data', 'name', 'class_name', 'class'));
    }
}
