<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/4/13 15:55
 */

namespace Tanwencn\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Tanwencn\Blog\Database\Eloquent\PostTag;
use Tanwencn\Blog\Http\Resources\DestroyResource;
use Tanwencn\Blog\Http\Resources\SaveResource;

class TagController extends Controller
{
    use SaveResource,DestroyResource;

    protected $model = PostTag::class;

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

    protected function _form(PostTag $model)
    {
        return $this->view('add_edit', compact('model'));
    }

    public function store()
    {
        return $this->save(new PostTag(), [
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
