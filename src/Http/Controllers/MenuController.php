<?php

namespace Tanwencn\Blog\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rule;
use Tanwencn\Blog\Database\Eloquent\Menu;
use Tanwencn\Blog\Database\RelationHelper;
use Tanwencn\Blog\Facades\Admin;

class MenuController extends Controller
{
    use ValidatesRequests;
    protected $model = Menu::class;

    public function create()
    {
        return $this->_form(new $this->model);
    }

    public function store()
    {
        return $this->save(new $this->model);
    }

    public function update($id)
    {
        return $this->save($this->model::findOrFail($id));
    }

    protected function _form($model)
    {
        $menus = Menu::all();

        $links = old('links', []);
        if (is_string($links)) $links = json_decode($links);

        $model->links = collect($links)->pipe(function ($collect) use ($model) {
            if ($collect->isEmpty()) {
                return $model->links;
            } else {
                return $collect;
            }
        });

        return $this->view('add_edit', compact('menus', 'model'));
    }

    public function edit($id)
    {
        $all_model = Menu::with(['links' => function ($query) {
            $query->with('linkable')->tree();
        }])->select(['id', 'title', 'slug'])->findOrFail($id);
        $all_model->links->load(['linkable' => function ($query) {
            if (method_exists($query->getModel(), 'trashed'))
                $query->withTrashed();
            if ($query->getMacro('withUnReleased'))
                $query->withUnReleased();
        }]);

        $n_model = Menu::with('links.linkable')->select(['id', 'title', 'slug'])->findOrFail($id);
        $invalid = $n_model->links->reject(function ($item) {
            return empty($item->linkable_id) || !empty($item->linkable);
        })->pluck('id')->all();

        if (!empty($invalid)) {
            $this->hasInvalid($all_model->links, $invalid);
        }

        return $this->_form($all_model)->with('invalid', $invalid);
    }

    protected function hasInvalid($collect, $invalid)
    {
        $collect->each(function ($item) use ($invalid) {
            if (in_array($item->id, $invalid))
                $item->invalid = true;
            if ($item->children) {
                $this->hasInvalid($item->children, $invalid);
            }
        });
    }

    protected function save($model)
    {
        $request = request();

        $input = $request->all();
        if (!empty($input['links'])) {
            $input['links'] = json_decode($input['links'], true);
            $request->request->replace($input);
        }

        $this->validate($request, [
            'title' => 'required|max:80',
            'slug' => [
                'required',
                'max:80',
                Rule::unique($model->getTable())->ignore($model->id)
            ]
        ]);

        RelationHelper::boot($model)->save();

        return redirect(Admin::action('edit', ['id' => $model->id]))->with('toastr_success', trans('admin.save_succeeded'));
    }
}
