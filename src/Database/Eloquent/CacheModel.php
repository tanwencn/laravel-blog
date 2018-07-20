<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/6/13 下午4:43
 */

namespace Tanwencn\Blog\Database\Eloquent;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class CacheModel extends Model
{
    use Cachable;
}