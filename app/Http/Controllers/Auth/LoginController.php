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
                ->with('error', 'Your account has been disabled.');
        }

        if ($user->id_role == '1') {
            return redirect()->route('admin.index')->with('success', 'Admin login successful.');;
        }
        if ($user->id_role == '2') {
            return redirect()->route('frontend.mentor')->with('success', 'Mentor login successful.');
        }
        if ($user->id_role == '3') {
            return redirect()->route('frontend.intern')->with('success', 'Intern login successful.');
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
