<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/3/16 15:57
 */

namespace Tanwencn\Blog\Database\Eloquent;

class Option extends Model
{
    protected $fillable = ['name', 'value'];
    public $timestamps = false;
    protected static $_options;

    public static function findByName(string $name, string $defalut = ''){
        $option = &static::$_options[$name];
        if (empty($option)) {
            try {
                $model = static::query()->where('name', $name)->select('value')->first();
                if ($model) {
                    $option = $model->value;
                }
            }catch (\Exception $e){}
        }
        return $option?:$defalut;
    }
}