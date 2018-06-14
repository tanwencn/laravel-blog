<?php

namespace Tanwencn\Blog\Database\Eloquent;

class Option extends Model
{
    protected $fillable = ['name', 'value'];
    public $timestamps = false;
    protected static $_options;

    public static function byName($name, $defalut = ''){
        $option = &static::$_options[$name];
        if (empty($option)) {
            $model = static::query()->where('name', $name)->select('value')->first();
            if($model){
                $option = $model->value;
            }
        }
        return $option?:$defalut;
    }
}