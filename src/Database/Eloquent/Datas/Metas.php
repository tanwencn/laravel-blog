<?php
/**
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/3/6 17:16
 */

namespace Tanwencn\Blog\Database\Eloquent\Datas;

use Tanwencn\Blog\Database\Collection\RanksCollection;

trait Metas
{
    public $relation_key = 'meta_key';

    public function bootIfNotBooted()
    {
        $this->timestamps = false;
        $this->touches = ['base'];
        $this->fillable(['meta_key', 'meta_value']);
        parent::bootIfNotBooted();
    }

    public function base()
    {
        return $this->belongsTo(str_before(get_class($this), 'Meta'), 'target_id');
    }

    public function newCollection(array $models = [])
    {
        return new RanksCollection($models);
    }

    public function setMetaValueAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['meta_value'] = json_encode($value);
        } else {
            $this->attributes['meta_value'] = $value;
        }
    }
}