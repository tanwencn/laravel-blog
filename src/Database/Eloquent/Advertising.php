<?php

namespace Tanwencn\Blog\Database\Eloquent;

use Tanwencn\Blog\Database\Eloquent\Datas\TermHasLinks;

class Advertising extends Model
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