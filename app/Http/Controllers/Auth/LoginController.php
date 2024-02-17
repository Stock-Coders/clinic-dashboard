<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function credentials(Request $request)
    {
        if(is_numeric($request->email)){
            return ['phone' => $request->email, 'password' => $request->password];
        }
        elseif(filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            return ['email' => $request->email, 'password' => $request->password];
        }
        else{
            return ['username' => $request->email, 'password' => $request->password];
        }
    }

    function authenticated(Request $request, $user){
        $user->update([
            'last_activity' => null, // Update last activity upon successful login
            'last_login_datetime' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);

        // For redirecting back to the last route when the authenticated user was logged in (after being logged ou because of inactivity "logic from the CheckUserActivityLogOut.php middleware")
            // Retrieve the intended URL from the session
            $intendedUrl = session('intended_url');
            // Redirect to the intended URL or a default route
            return redirect()->intended($intendedUrl ?: route('dashboard'));
    }

}
