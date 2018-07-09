<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/3/14 16:59
 */

namespace Tanwencn\Blog\Database\Eloquent;

use Tanwencn\Blog\Database\Eloquent\Datas\TermHasLinks;

class Advertising extends CacheModel
{
    use TermHasLinks;

    public static function byId($id)
    {
        $model = static::with(['links' => function ($query) {
            return $query->with('linkable')->tree();
        }])->select(['id', 'title', 'slug'])->findOrFail($id);
        return $model;
    }
}