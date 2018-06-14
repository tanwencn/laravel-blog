<?php
/**
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/3/7 10:56
 */

namespace Tanwencn\Blog\Database\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Tanwencn\Blog\Database\Eloquent\Concerns\HasChildrens;
use Tanwencn\Blog\Database\Scopes\LatestScope;
use Tanwencn\Blog\Database\Scopes\ReleaseScope;

class Comment extends Model
{
    use HasChildrens;

    protected $fillable = ['parent_id', 'message'];

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ReleaseScope());
        static::addGlobalScope(new LatestScope());
        static::saving(function($model){
            $model->user_id = Auth::id()?:0;
            $model->ip_address = request()->getClientIp();
        });
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}