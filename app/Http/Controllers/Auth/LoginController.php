<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
    protected $redirectTo = '/';

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

    public function showUserLoginForm()
    {
        return view('auth.login');
    }

    public function userLogin(Request $request)
    {   
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors([
                'input' => 'Input tidak valid! Harap periksa kembali.',
            ]);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('Dashboard');
        } else {
            $userExists = User::where('email', $request->email)->exists();
        
            if ($userExists) {
                return back()->withErrors([
                    'password' => 'Kata sandi tidak cocok.'
                ]);
            } else {
                return back()->withErrors([
                    'email' => 'Email tidak terdaftar.'
                ]);
            }
        }
    }
}
