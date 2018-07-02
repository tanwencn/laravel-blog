<?php

namespace Tanwencn\Blog\Http\Controllers;

use Tanwencn\Blog\Facades\Admin;

class DashboardController extends Controller
{
    public function index(){
        $this->authorize('dashboard');
        return Admin::view('dashboard.index');
    }

    protected function abilitiesMap()
    {
        return [];
    }


}
