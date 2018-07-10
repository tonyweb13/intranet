<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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

    use AuthenticatesUsers {
        login as public traitLogin;
    }

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
    }

    public function username(): string
    {
        return 'employee_no';
    }

    // public function authenticate(Request $request)
    // {
    //     if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'is_active' => 1])) {
    //         return response()->json($user);
    //     } else {

    //     }
    // }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($request->ajax() || $request->wantsJson()) {

            $user = User::where('id', Auth::user()->id);
            $userInfo = $user->with(['department', 'designation', 'employment_type', 'address','government_credential'])->first();

            return response()->json($userInfo);

        }

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    public function showLoginForm()
    {
        return view('index');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $response = [
            'errors' => 'Invalid Login',
            'message' => 'These credentials do not match our records.'
        ];
        return response()->json($response);//response('Hello World', 200)->header('Content-Type', 'text/json');
    }

    public function login(Request $request)
    {
        $cookie = cookie()->forever('employee_no', $request->employee_no);
        return $this->traitLogin($request)->cookie($cookie);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect('/login');
    }

}