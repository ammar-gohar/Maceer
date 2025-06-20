<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Barryvdh\Debugbar\Facades\Debugbar as FacadesDebugbar;
use DebugBar\DebugBar;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/home';

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

    protected function credentials(Request $request)
    {
        $login = is_numeric($request->email) ? ([
            'national_id' => $request->email,
        ]) : (filter_var($request->email, FILTER_VALIDATE_EMAIL) ? ([
            'email' => $request->email,
        ]) : ([
            'username' => $request->email,
        ]));

        $login['password'] = $request->password;

        return $login;
    }

}
