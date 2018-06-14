<?php

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
        return view('tanwencms::admin.widgets.dashboard_right', compact('users_count', 'comments_count'));
    }
}
