<?php

namespace Tanwencn\Blog\Database\Eloquent\Datas;

use Illuminate\Support\Facades\DB;
use Tanwencn\Blog\Database\Eloquent\Concerns\HasChildrens;
use Tanwencn\Blog\Database\Eloquent\Link;
use Tanwencn\Blog\Database\Scopes\OldestScope;
use Tanwencn\Blog\Database\Scopes\TaxonomyScope;

trait Terms
{
    use HasChildrens;

    public $relation_key = 'title';

    public function __construct()
    {
        $this->fillable(['title', 'slug', 'parent_id']);

        $this->setTable('terms');

        parent::__construct();
    }

    protected static function bootTerms()
    {
        static::addGlobalScope(new TaxonomyScope);
        static::addGlobalScope(new OldestScope('order'));

        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && !$model->isForceDeleting()) {
                return;
            }

            //清除多态关系链
            DB::table('termables')->where('term_id', $model->id)->delete();

            //删除和link表多态一对一的项目
            $model->morphMany(Link::class, 'linkable')->delete();

            //删除和link表一对多的项目
            if (method_exists($model, 'links')) {
                Link::destroy($model->links->pluck('id'));
            }
        });

        static::saving(function ($model) {
            $model->taxonomy = snake_case(class_basename($model));
        });
    }

    public function setFirstSlugAttribute($value)
    {
        $this->attributes['slug'] = ucfirst($value);
    }

    public function getUrlAttribute()
    {
        return url('/'.kebab_case(class_basename($this)).'/'.$this->getKey());
    }

    /*public function terms()
    {
        return $this->morphToMany(
            config('permission.models.role'),
            'model',
            config('permission.table_names.model_has_roles'),
            'model_id',
            'role_id'
        );
    }*/
}