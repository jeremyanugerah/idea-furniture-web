<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
    // Use middleware so the login function can only be accessed by 'Guest'
    // except for logout function.
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

     /**
     * Attempt login
     */
    protected function attemptLogin(Request $request)
    {
        // check user credentials
        $result = $this->guard()->attempt(
            $this->credentials($request)
        );

        // if user exists in the database and checks 'remember me'
        if($result == true  && $request->has('remember')){ 
            $user = $this->guard()->user();

            // Cookie with expired time of 12 hours
            $customRememberMeTimeInMinutes = 12 * 60;  
            $this->guard()->getCookieJar()->queue(
                $this->guard()->getCookieJar()->make($this->guard()->getRecallerName(), $user->getAuthIdentifier().'|'.$user->getRememberToken().'|'.$user->getAuthPassword(), $minutes = $customRememberMeTimeInMinutes)
            );
        }

        return $result;
    }
}