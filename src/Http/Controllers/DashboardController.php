<?php

namespace Tanwencn\Blog\Http\Controllers;

use Tanwencn\Blog\Facades\Admin;

class DashboardController extends Controller
{

    public function index(){
        //$this->setPageTitle(trans('admin.dashboard'));
        //$this->setPageDesc(trans('admin.control_panel'));
        return Admin::view('dashboard.index');
    }


}
