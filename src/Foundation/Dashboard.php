<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/6/15 下午2:59
 */

namespace Tanwencn\Blog\Foundation;

class Dashboard
{
    public function left($widget, $config = [], $position = 100)
    {
        \Widget::group('admin_dashboard_left')->position($position)->addWidget($widget, $config);
    }

    public function right($widget, $config = [], $position = 100)
    {
        \Widget::group('admin_dashboard_right')->position($position)->addWidget($widget, $config);
    }
}