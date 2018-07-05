<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/3/16 15:57
 */

namespace Tanwencn\Blog\Database\Eloquent;


use Illuminate\Database\Eloquent\Model;
use Tanwencn\Blog\Database\Eloquent\Concerns\HasChildrens;

class Link extends Model
{
    use HasChildrens;

    public $timestamps = false;
    public $tree_filed = '*';

    protected $guarded = [];

    public function linkable()
    {
        return $this->morphTo();
    }

    public function hasLinkable()
    {
        return (bool)$this->linkable_id;
    }

    public function getUrlAttribute($value)
    {
        return empty($value) && $this->hasLinkable() ? $this->linkable->url : $value;
    }

    public function getImageAttribute($value)
    {
        return empty($value) && $this->hasLinkable() ? $this->linkable->image : $value;
    }

    public function getTitleAttribute($value)
    {
        return empty($value) && $this->hasLinkable() ? $this->linkable->title : $value;
    }
}