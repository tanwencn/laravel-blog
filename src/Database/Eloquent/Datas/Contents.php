<?php
/**
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/3/6 17:16
 */

namespace Tanwencn\Blog\Database\Eloquent\Datas;

use Illuminate\Database\Eloquent\SoftDeletes;
use Tanwencn\Blog\Database\Eloquent\Comment;
use Tanwencn\Blog\Database\Eloquent\concerns\HasMetas;
use Tanwencn\Blog\Database\Eloquent\ContentMeta;
use Tanwencn\Blog\Database\Eloquent\Link;
use Tanwencn\Blog\Database\Scopes\LatestScope;
use Tanwencn\Blog\Database\Scopes\OldestScope;
use Tanwencn\Blog\Database\Scopes\ReleaseScope;
use Tanwencn\Blog\Database\Scopes\TaxonomyScope;

trait Contents
{
    use HasMetas,SoftDeletes;

    public function bootIfNotBooted()
    {
        $this->setTable('contents');
        $this->fillable(['title', 'excerpt', 'description', 'is_release', 'order']);
        parent::bootIfNotBooted();
    }

    public static function bootContents()
    {
        static::addGlobalScope(new ReleaseScope());
        static::addGlobalScope(new TaxonomyScope());
        static::addGlobalScope(new OldestScope('order'));
        static::addGlobalScope(new LatestScope());

        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && !$model->isForceDeleting()) {
                return;
            }

            $model->morphMany(Link::class, 'linkable')->delete();

            $model->metas()->forceDelete();

            if (method_exists($model, 'comments'))
                $model->comments()->detach();

            if (method_exists($model, 'categories'))
                $model->categories()->detach();
        });

        static::saving(function ($model) {
            $model->taxonomy = snake_case(class_basename($model));
        });
    }

    public function metas()
    {
        return $this->hasMany(ContentMeta::class, 'target_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    protected function terms($related)
    {
        return $this->morphToMany($related, 'termable', null, null, 'term_id');
    }

    public function getImageAttribute()
    {
        return $this->getMetas('image');
    }

    public function getDescriptionAttribute()
    {
        return $this->getMetas('description');
    }

    public function canComment(){
        return true;
    }

    public function isAuditComment(){
        return true;
    }

    public function getUrlAttribute()
    {
        return url('/'.kebab_case(class_basename($this)).'/'.$this->getKey());
    }

    public static function destroy($ids)
    {
        // We'll initialize a count here so we will return the total number of deletes
        // for the operation. The developers can then check this number as a boolean
        // type value or get this total count of records deleted for logging, etc.
        $count = 0;

        $ids = is_array($ids) ? $ids : func_get_args();

        // We will actually pull the models from the database table and call delete on
        // each of them individually so that their events get fired properly with a
        // correct set of attributes in case the developers wants to check these.
        $key = ($instance = new static)->getKeyName();

        foreach ($instance->withUnReleased()->withTrashed()->whereIn($key, $ids)->get() as $model) {
            if ($model->trashed() && $model->forceDelete() || $model->delete()) {
                $count++;
            }
        }

        return $count;
    }
}