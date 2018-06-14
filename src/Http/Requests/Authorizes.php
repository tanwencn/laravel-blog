<?php
/**
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/6/7 下午6:48
 */

namespace Tanwencn\Blog\Http\Requests;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

trait Authorizes
{
    use AuthorizesRequests;

    public function callAction($method, $parameters)
    {
        if (!Auth::user()->hasRole('superadmin')) {
            if ($ability = $this->getAbility($method)) {
                $this->authorize($ability);
            }
        }

        return parent::callAction($method, $parameters);
    }


    /**
     * Get ability
     *
     * @param $method
     * @return null|string
     */
    public function getAbility($method)
    {
        $routeName = explode('.', str_after(request()->route()->getName(), 'admin.'));
        $action = array_get($this->abilitiesMap(), $method);

        return $action ? $action . '_' . str_singular($routeName[0]) : null;
    }

    /**
     * @return array
     */
    protected function abilitiesMap()
    {
        return [
            'index' => 'view',
            'edit' => 'edit',
            'show' => 'view',
            'update' => 'edit',
            'create' => 'add',
            'store' => 'add',
            'destroy' => 'delete'
        ];
    }
}