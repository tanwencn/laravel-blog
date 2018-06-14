<?php

namespace Tanwencn\Blog\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers, ValidatesRequests;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function($request, $next){
            if(Auth::check() && Auth::user()->hasPermissionTo('view_dashboard')){
                return redirect($this->redirectPath());
            }
            return $next($request);
        })->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin::auth.login');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect($this->redirectPath());
    }

    protected function redirectTo()
    {
        return '/'.config('admin.route.prefix', 'admin');
    }
}
