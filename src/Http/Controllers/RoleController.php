<?php

namespace Tanwencn\Blog\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use ValidatesRequests;

    public function index(Request $request)
    {
        $model = Role::query();
        $search = $request->query('search');
        if (!empty($search)) {
            $model->where(function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            });
        }

        $results = $model->paginate();

        return $this->view('index', compact('results'));
    }

    public function create()
    {
        return $this->_form(new Role());
    }

    protected function _form(Role $model)
    {
        $permissions = Permission::all();

        $current_abilities = old('permissions', $model->permissions->pluck('id')->toArray());

        return $this->view('add_edit', compact('model', 'permissions', 'current_abilities'));
    }

    public function edit($id)
    {
        $model = Role::findOrFail($id);

        return $this->_form($model);
    }

    public function store()
    {
        return $this->save(new Role());
    }

    public function update($id)
    {
        $role = Role::findOrfail($id);
        if ($role->name == 'superadmin' && request()->input('name') != $role->name) {
            abort(401);
        }
        return $this->save($role);
    }

    protected function save(Role $model)
    {
        $request = request();

        $this->validate($request, [
            'name' => 'required|max:255',
            'permissions' => 'required|array'
        ]);

        $permissions = $request->input('permissions');

        $model->name = $request->input('name');
        $model->save();

        $model->syncPermissions($permissions);

        return redirect(\Admin::action('index'))->with('toastr_success', trans('admin.save_succeeded'));
    }

    public function destroy($id)
    {
        $ids = explode(',', $id);
        foreach ($ids as $id) {
            $model = Role::findOrFail($id);
            if ($model->name == 'superadmin') continue;
            $model->delete();
        }

        return response([
            'status' => true,
            'message' => trans('admin.delete_succeeded'),
        ]);
    }
}