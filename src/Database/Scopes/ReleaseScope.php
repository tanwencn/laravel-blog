<?php
/**
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/3/14 14:16
 */

namespace Tanwencn\Blog\Database\Scopes;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ReleaseScope implements Scope
{
    protected $extensions = ['WithUnReleased', 'OnlyUnReleased'];

    public function apply(Builder $builder, Model $model)
    {
        return $builder->where('is_release', 1);
    }

    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    protected function addWithUnReleased(Builder $builder){
        $builder->macro('withUnReleased', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    protected function addOnlyUnReleased(Builder $builder){
        $builder->macro('onlyUnReleased', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_release', 0);
        });
    }
}