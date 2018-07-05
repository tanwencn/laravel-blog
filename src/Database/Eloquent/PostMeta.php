<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/3/7 10:56
 */

namespace Tanwencn\Blog\Database\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Tanwencn\Blog\Database\Eloquent\Datas\Metas;

class PostMeta extends Model
{
    use Metas;

    protected $table = 'content_metas';
}