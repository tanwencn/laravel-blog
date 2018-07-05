<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/4/13 15:55
 */

namespace Tanwencn\Blog\Widgets;

use App\User;
use Arrilot\Widgets\AbstractWidget;
use Tanwencn\Blog\Database\Eloquent\Comment;

class DashboardRightWidget extends AbstractWidget
{
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $users_count = User::count();
        $comments_count = Comment::count();
        return view('admin::widgets.dashboard_right', compact('users_count', 'comments_count'));
    }
}
