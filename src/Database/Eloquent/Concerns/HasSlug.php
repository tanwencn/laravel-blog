<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/3/14 16:59
 */

namespace Tanwencn\Blog\Database\Eloquent\Concerns;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected $slug_length = 200;

    protected static function bootHasSlug()
    {
        static::saving(function (Model $model) {
            $model->generateSlug();
        });

        static::saved(function (Model $model) {
            if($model->slug == 'pk'){
                $model->slug = $model->getKey();
                $model->save();
            }
        });
    }

    protected function generateSlug()
    {
        $slug = $this->generateUniqueSlug();

        $this->slug = $slug;
    }

    protected function generateUniqueSlug()
    {
        $slug = $this->hasCustomSlugBeenUsed() ? $this->slug : '';

        $slug = trim($slug) ?: str_slug($this->title);

        if (empty($slug)) return "pk";

        $results = str_limit($slug, $this->slug_length-10, "");

        $i = 1;

        while ($this->otherRecordExistsWithSlug($slug)) {
            $results = $slug . $i++;
        }

        return $results;
    }

    protected function hasCustomSlugBeenUsed(): bool
    {
        return $this->getOriginal('slug') != $this->slug;
    }

    protected function otherRecordExistsWithSlug(string $slug): bool
    {
        $key = $this->getKey();

        if ($this->incrementing) {
            $key = $key ?? '0';
        }

        return (bool)static::where('slug', $slug)
            ->where($this->getKeyName(), '!=', $key)
            ->withoutGlobalScopes()
            ->count();
    }

    public function scopeFindBySlug(Builder $query, string $slug, array $columns = ['*'])
    {
        return $query->where('slug', $slug)->first($columns);
    }

    public static function scopeFindBySlugOrFail(Builder $query, string $slug, array $columns = ['*'])
    {
        return $query->where('slug', $slug)->firstOrFail($columns);
    }
}