<?php
/**
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/3/14 16:59
 */

namespace Tanwencn\Blog\Database\Eloquent\Concerns;


trait HasMetas
{
    public function metas()
    {
        return $this->hasMany(static::class.'Meta', 'target_id');
    }

    public function getMetas($key)
    {
        return $this->metas->getRanks($key);
    }

    public function relationFormatMetas($data){
        $metas = [];
        $data = array_filter($data);
        foreach ($data as $key => $val){
            if(isset($val['meta_key'])) {
                $metas[] = $val;
            }else{
                $metas[] = ['meta_key' => $key, 'meta_value' => $val];
            }
        }
        return  $metas;
    }
}