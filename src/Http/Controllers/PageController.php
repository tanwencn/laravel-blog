<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/4/13 15:55
 */

namespace Tanwencn\Blog\Http\Controllers;

use Tanwencn\Blog\Database\Eloquent\Page;
use Tanwencn\Blog\Http\Resources\ContentResource;

class PageController extends Controller
{
    use ContentResource;

    protected $model = Page::class;
}
