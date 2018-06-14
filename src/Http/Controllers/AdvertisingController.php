<?php

namespace Tanwencn\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Tanwencn\Blog\Database\Eloquent\Advertising;
use Tanwencn\Blog\Http\Resources\DestroyResource;
use Tanwencn\Blog\Http\Resources\SaveResource;

class AdvertisingController extends Controller
{
    use DestroyResource,SaveResource;

    protected $model = Advertising::class;

    public function index(Request $request)
    {
        $model = Advertising::withCount('links')->orderByDesc('id');

        $search = $request->query('search');

        if (!empty($search)) {
            $model->where('title', 'like', "%{$search}%");
            $model->orWhere('slug', 'like', "%{$search}%");
        }

        $results = $model->paginate();

        return $this->view('index', compact('results', 'title'));
    }

    public function create()
    {
        return $this->_form(new $this->model);
    }

    protected function _form($model)
    {
        $model->links = collect(old('links', []))->pipe(function ($collect) use ($model) {
            if ($collect->isEmpty()) {
                return $model->links;
            } else {
                return $collect;
            }
        });

        return $this->view('add_edit', compact('model'));
    }

    public function edit($id)
    {
        $all_model = Advertising::with('links')->select(['id', 'title', 'slug'])->findOrFail($id);
        $all_model->links->load(['linkable' => function ($query) {
            if (method_exists($query->getModel(), 'trashed'))
                $query->withTrashed();
            if ($query->getMacro('withUnReleased'))
                $query->withUnReleased();
        }]);

        $n_model = Advertising::with('links.linkable')->select(['id', 'title', 'slug'])->findOrFail($id);
        $invalid = $n_model->links->reject(function ($item) {
            return empty($item->linkable_id) || !empty($item->linkable);
        })->pluck('id')->all();

        if (!empty($invalid)) {
            $all_model->links->whereIn('id', $invalid)->each(function ($item, $key) {
                $item->invalid = true;
            });
        }

        $view = $this->_form($all_model);

        if($invalid)
            $view->withErrors(trans('admin.invalid_prompt'));

        return $view;
    }

    public function store()
    {
        $model = new $this->model;
        return $this->save($model, [
            'title' => 'required|max:80',
            'slug' => [
                'required',
                'max:80',
                Rule::unique($model->getTable())->ignore($model->id)
            ]
        ]);
    }

    public function update($id)
    {
        $model = $this->model::findOrfail($id);
        return $this->save($model, [
            'title' => 'required|max:80',
            'slug' => [
                'required',
                'max:80',
                Rule::unique($model->getTable())->ignore($model->id)
            ]
        ]);
    }
}
