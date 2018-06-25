<?php

namespace Tanwencn\Blog\Http\Controllers;

use Igaster\LaravelTheme\Facades\Theme;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Tanwencn\Blog\Database\Eloquent\Option;
use Tanwencn\Blog\Facades\Admin;

class OptionController extends Controller
{
    use AuthorizesRequests;

    public function general()
    {
        $this->authorize('general_settings');

        $themes = Theme::all();

        return Admin::view('options.general', compact('themes'));
    }

    public function general_store()
    {
        $this->authorize('general_settings');

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
