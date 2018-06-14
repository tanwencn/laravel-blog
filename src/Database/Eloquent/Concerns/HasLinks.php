<?php
/**
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/3/14 16:59
 */

namespace Tanwencn\Blog\Database\Eloquent\Concerns;


use Illuminate\Support\Collection;
use Tanwencn\Blog\Database\Eloquent\Datas\Terms;
use Tanwencn\Blog\Database\Eloquent\Link;

trait HasLinks
{
    use Terms;

    public function links()
    {
        return $this->hasMany(Link::class, 'term_id');
    }

    public static function bySlug($slug, $auto_load = true)
    {
        $model = static::with(['links' => function ($query) use ($auto_load) {
            if ($auto_load)
                return $query->with('linkable')->tree();
            else
                return $query->where('parent_id', 0);
        }])->select(['id', 'title', 'slug'])->where('slug', ucfirst($slug))->first();
        return $model?$model->links:new Collection();
    }
}