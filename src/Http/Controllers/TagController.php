<?php

namespace Tanwencn\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Tanwencn\Blog\Database\Eloquent\PostsTag;
use Tanwencn\Blog\Http\Resources\DestroyResource;
use Tanwencn\Blog\Http\Resources\SaveResource;

class TagController extends Controller
{
    use SaveResource,DestroyResource;

    protected $model = PostsTag::class;

    public function index(Request $request)
    {
        $model = $this->model::orderByDesc('id');

        $search = $request->query('search');
        if (!empty($search)) {
            $model->where('title', 'like', "%{$search}%");
        }

        $results = $model->paginate();

        return $this->view('index', compact('results'));
    }

    public function create()
    {
        return $this->_form(new $this->model);
    }

    public function edit($id)
    {
        return $this->_form($this->model::findOrFail($id));
    }

    protected function _form(PostsTag $model)
    {
        return $this->view('add_edit', compact('model'));
    }

    public function store()
    {
        return $this->save(new PostsTag(), [
            'title' => 'required|max:80'
        ]);
    }

    public function update($id)
    {
        return $this->save($this->model::findOrFail($id), [
            'title' => 'required|max:80'
        ]);
    }
}
