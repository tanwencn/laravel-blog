<?php
/**
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/3/14 16:59
 */

namespace Tanwencn\Blog\Database\Eloquent\Datas;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Tanwencn\Blog\Database\Eloquent\Link;

trait TermHasLinks
{
    use Terms;

    protected static function bootTermHasLinks()
    {
        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && !$model->isForceDeleting()) {
                return;
            }

            $results = $model->morphMany(Link::class, 'linkable')->get();

            foreach ($results as $link) {
                $link->delete();
            }

            foreach ($model->links as $link) {
                $link->delete();
            }
        });
    }

    public function links()
    {
        return $this->hasMany(Link::class, 'term_id');
    }

    public function scopeFindBySlug(Builder $query, string $slug, bool $auto_load = true)
    {
        $model = $query->with(['links' => function (Builder $squery) use ($auto_load) {
            if ($auto_load)
                return $squery->with('linkable')->tree();
            else
                return $squery->where('parent_id', 0);
        }])->select(['id', 'title', 'slug'])->where('slug', ucfirst($slug))->first();
        return $model ? $model->links : new Collection();
    }
}