<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/6/7 下午6:48
 */

namespace Tanwencn\Blog\Http\Resources;

use Illuminate\Http\Request;

trait ContentResource
{
    use DestroyResource, SaveResource;

    public function index(Request $request)
    {
        //基础数据
        $model = $this->model::query();

        if(method_exists($model, 'categories')) $model->with('categories');
        if(method_exists($model, 'tags')) $model->with('tags');

        //筛选器
        $trashed = $request->query('trashed');
        $search = $request->query('search');
        $release = $request->query('release');

        if (!$trashed && !$release) {
            $model->withUnReleased();
        } else {
            if ($trashed) {
                $model->onlyTrashed();
                $model->withUnReleased();
            } else if ($release != 'up') {
                $model->onlyUnReleased();
            }
        }

        if (!empty($search)) {
            $model->where('title', 'like', "%{$search}%");
            $model->orWhereHas('categories', function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            });
            $model->orWhereHas('tags', function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            });
        }

        $results = $model->paginate();

        $statistics = [
            'total' => $this->model::withUnReleased()->count(),
            'release' => $this->model::count(),
            'unrelease' => $this->model::onlyUnReleased()->count(),
            'delete' => $this->model::onlyTrashed()->withUnReleased()->count()
        ];

        return $this->view('index', compact('results', 'statistics', 'title'));
    }

    public function create()
    {
        return $this->_form(new $this->model);
    }

    public function edit($id)
    {
        $model = $this->model::withUnReleased()->findOrFail($id);

        return $this->_form($model);
    }

    protected function _form($model)
    {
        $model->load('metas');

        $data = compact('model');

        if (method_exists($model, 'categories')) {
            $class = get_class($model->categories()->getModel());
            $categories = $class::tree()->get();
            $model->categories = old('categories', $model->categories->pluck('id')->toArray());
            $data['categories'] = $categories;
        }

        if (method_exists($model, 'tags')) {
            $class = get_class($model->tags()->getModel());
            $tags = $class::select('id', 'parent_id', 'title')->get();
            $model->tags = old('tags', $model->tags->pluck('id')->toArray());
            $data['tags'] = $tags;
        }

        return $this->view('add_edit', $data);
    }

    public function store()
    {
        return $this->save(new $this->model, $this->validatesMap());
    }

    protected function validatesMap(){
        return [
            'title' => 'required|max:120',
            'excerpt' => 'max:255',
        ];
    }

    public function update($id, Request $request)
    {
        $action = $request->input('_only');
        $only = ['is_release', 'restore'];
        if (in_array($action, $only)) {
            $input = $request->only($only);
            $ids = explode(',', $id);
            foreach ($ids as $id) {
                if (empty($id)) {
                    continue;
                }

                if ($action == 'restore') {
                    $model = $this->model::withUnReleased()->onlyTrashed()->findOrFail($id);
                    $model->restore();
                } else {
                    $model = $this->model::withUnReleased()->findOrFail($id);
                    $model->fill($input)->save();
                }
            }
            return response([
                'status' => true,
                'message' => trans('admin.save_succeeded'),
            ]);
        }

        $model = $this->model::withUnReleased()->findOrFail($id);

        return $this->save($model, $this->validatesMap());
    }
}