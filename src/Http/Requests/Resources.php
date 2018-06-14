<?php
/**
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/6/7 下午6:48
 */

namespace Tanwencn\Blog\Http\Requests;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

trait Resources
{
    use ValidatesRequests;

    public function create()
    {
        return $this->_form(new $this->model);
    }

    public function destroy($id)
    {
        $ids = explode(',', $id);
        foreach ($ids as $id) {
            if (empty($id)) {
                continue;
            }
            DB::transaction(function () use ($id) {
                $this->delete($id);
            });
        }

        return response([
            'status' => true,
            'message' => trans('admin.delete_succeeded'),
        ]);
    }

    protected function delete($id)
    {
        $model = $this->model::findOrFail($id);
        $model->delete();
    }

    public function store()
    {
        return $this->save(new $this->model);
    }

    public function update($id)
    {
        return $this->save($this->model::findOrfail($id));
    }

    protected function save($model)
    {
        $request = request();

        $this->validate($request, $this->validateMap($model));

        RelationHelper::boot($model)->save();

        return redirect(method_exists($this, 'redirectPath')?$this->redirectPath($model):Admin::action('index'))->with('toastr_success', trans('admin.save_succeeded'));
    }

    protected function validateMap($model)
    {
        return [];
    }
}