<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->status == 'inactive') {

            Auth::logout();

            return redirect()
                ->route('login')
                ->with('error', 'Tài khoản của bạn đã bị vô hiệu hóa');
        }

        if ($user->id_role == '1') {
            return redirect()->route('admin.index')->with('success', 'Đăng nhập trang quản trị thành công');;
        }
        if ($user->id_role == '2') {
            return redirect()->route('home')->with('success', 'Đăng nhập trang người dùng thành công');
        }
        if ($user->id_role == '3') {
            return redirect()->route('frontend.intern')->with('success', 'Đăng nhập trang thực tập sinh thành công');
        }
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
