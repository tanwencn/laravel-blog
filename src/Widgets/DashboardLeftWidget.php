<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/4/13 15:55
 */

namespace Tanwencn\Blog\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Tanwencn\Blog\Database\Eloquent\Page;
use Tanwencn\Blog\Database\Eloquent\Post;

class DashboardLeftWidget extends AbstractWidget
{
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $posts_count = Post::count();
        $pages_count = Page::count();
        return view('admin::widgets.dashboard_left', compact('posts_count', 'pages_count'));
    }
}
