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
use Tanwencn\Blog\Database\Eloquent\Comment;
use Tanwencn\Blog\Database\Eloquent\Post;
use Tanwencn\Blog\Http\Resources\SaveResource;

class CommentController extends Controller
{
    use SaveResource;

    protected $model = Comment::class;

    public function index(Request $request)
    {
        //基础数据
        $model = $this->model::ableType(Post::class)->with('commentable', 'user');

        //筛选器
        $release = $request->query('release');
        $search = $request->query('search');

        if (!$release) {
            $model->withUnReleased();
        } else {
            if ($release != 'up') {
                $model->onlyUnReleased();
            }
        }

        if($search){
            $model->where('content', 'like', "%{$search}%");
        }

        $results = $model->paginate();

        $statistics = [
            'total' => $this->model::withUnReleased()->count(),
            'release' => $this->model::count(),
            'unrelease' => $this->model::onlyUnReleased()->count()
        ];

        return $this->view('index', compact('results', 'statistics', 'title'));
    }

    public function update($id, Request $request)
    {
        $action = $request->input('_only');
        $only = ['is_release'];
        if (in_array($action, $only)) {
            $input = $request->only($only);
            $ids = explode(',', $id);
            foreach ($ids as $id) {
                if (empty($id)) {
                    continue;
                }

                $model = $this->model::ableType(Post::class)->withUnReleased()->findOrFail($id);
                foreach ($input as $key => $val) {
                    $model->setAttribute($key, $val);
                }
                $model->save();
            }
            return response([
                'status' => true,
                'message' => trans('admin.save_succeeded'),
            ]);
        }
    }

    public function destroy($id)
    {
        $ids = explode(',', $id);

        $models = $this->model::ableType(Post::class)->withUnReleased()->find($ids);

        foreach ($models as $model) {
            $model->delete();
        }

        return response([
            'status' => true,
            'message' => trans('admin.delete_succeeded'),
        ]);
    }
}
