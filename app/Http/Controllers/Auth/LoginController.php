<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Exception;
use Carbon\Carbon;
use App\Models\Carers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:carer', ['except' => ['logout', 'expired']]);
    }

    //Custom guard for carer
    protected function guard() {
        return Auth::guard('carer');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request) {
        $this->guard('carer')->logout();
        $request->session()->flush();
        //$request->session()->regenerate();

        return redirect('/');
    }

    /**
     * Log the user out of the application.
     * And redirect to the session timeout page.
     *
     * Remember to add method to the constructor!
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function expired(Request $request) {
        $this->guard('carer')->logout();
        return view('errors.440')->with(['login' => 'login']);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request) {
        $this->validate($request, ['login' => 'required', 'password' => 'required']);

        $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL )
            ? 'email'
            : 'username';

        $request->merge([
            $login_type => $request->input('login')
        ]);

        if (Auth::guard('carer')->attempt([$login_type => $request->login, 'password' => $request->password], $request->remember)) {
            $user = Auth::guard('carer')->user();
            // Check if $user and OU are active or not
            if (!$user->active) {
                flash()->overlay("Your account has been suspended. Please contact system administrator for assistance", "Account Suspended");
                Auth::guard('carer')->logout();
                return back();
            }
            return redirect()->intended(route('home'));
        }

        //return redirect()->back()->withInput($request->only('email', 'remember'));

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

}
