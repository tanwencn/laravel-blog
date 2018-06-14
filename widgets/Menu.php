<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Tanwencn\Blog\Database\Eloquent\Menu as Model;

class Menu extends AbstractWidget
{

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        abort_unless($this->config['slug'], 500, 'Invalid parameters:slug');
        $data = Model::bySlug($this->config['slug']);
        return view('widgets.menu', compact('data'));
    }
}
