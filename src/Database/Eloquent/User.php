<?php

namespace Tanwencn\Blog\Database\Eloquent;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tanwencn\Blog\Database\Eloquent\concerns\HasMetas;

class User extends Authenticatable
{
    use HasRoles, HasMetas, Notifiable;

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot()
    {
        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && !$model->isForceDeleting()) {
                return;
            }

            $model->comments()->delete();
            $model->metas()->delete();
        });
    }

    public function getNameAttribute($value)
    {
        return $value ?: $this->email;
    }

    public function metas()
    {
        return $this->hasMany(UserMeta::class, 'target_id');
    }

    public function getAvatarAttribute()
    {
        return $this->getMetas('avatar') ?: asset('/vendor/laravel-blog/logo.png');
    }

    public function getMorphClass()
    {
        return self::class;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}