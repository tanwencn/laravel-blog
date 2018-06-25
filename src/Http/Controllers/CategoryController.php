<?php

namespace Tanwencn\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Tanwencn\Blog\Database\Eloquent\PostCategory;
use Tanwencn\Blog\Http\Resources\DestroyResource;
use Tanwencn\Blog\Http\Resources\SaveResource;

class CategoryController extends Controller
{
    use SaveResource, DestroyResource;
    protected $model = PostCategory::class;

    public function create()
    {
        return $this->_form(new $this->model);
    }

    public function index()
    {
        return $this->view('index', [
            'data' => $this->model::tree()->get()
        ]);
    }

    public function edit($id)
    {
        return $this->_form($this->model::findOrFail($id));
    }

    protected function _form(PostCategory $model)
    {
        $data = PostCategory::tree()->get();

        return $this->view('add_edit', compact('model', 'data'));
    }

    public function store()
    {
        return $this->save(new $this->model, [
            'title' => 'required|max:80'
        ]);
    }

    public function order(Request $request)
    {
        if ($request->input('_nestable')) {
            $data = json_decode($request->input('nestable', []), true);
            PostCategory::saveOrder($data);

            return response([
                'status' => true,
                'message' => trans('admin.save_succeeded'),
            ]);
        }
    }

    public function update($id)
    {
        return $this->save($this->model::findOrFail($id), [
            'title' => 'required|max:80'
        ]);
    }

    protected function abilitiesMap()
    {
        return array_merge(parent::abilitiesMap(), [
            'order' => 'edit'
        ]);
    }


}
