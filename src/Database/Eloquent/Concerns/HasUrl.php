<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/3/14 16:59
 */

namespace Tanwencn\Blog\Database\Eloquent\Concerns;


trait HasUrl
{
    public static function bootHasUrl()
    {
        static::registerModelEvent('init', function ($model) {
            $model->setAppends(array_merge($model->appends, ['url']));
        });
    }

    public function getUrlAttribute()
    {
        return url('/' . kebab_case(class_basename($this)) . '/' . ($this->slug ?: $this->getKey()));
    }
}