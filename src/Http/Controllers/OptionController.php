<?php

namespace Tanwencn\Blog\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Tanwencn\Blog\Database\Eloquent\Option;

class OptionController extends Controller
{

    public function general()
    {
        if (!Auth::user()->hasRole('superadmin'))
            $this->authorize('general_settings');

        $this->setPageTitle(trans('admin.general_settings'));
        return $this->view('options.general');
    }

    public function store()
    {
        $options = request('options');

        foreach ($options as $name => $option) {
            $model = Option::firstOrNew([
                'name' => $name
            ]);
            $model->value = $option ?: '';
            $model->save();
        }

        return response()->json([
            'status' => true,
            'message' => trans('admin.save_succeeded')
        ]);
    }

}
