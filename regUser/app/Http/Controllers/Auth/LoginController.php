<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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
        return [
            'email' => $request->email,
            'password' => $request->password,
            'status' => '1', // or 'active' if you use string
        ];
    }
    

    protected function authenticated(Request $request, $user)
{
    if ($user->status != '1') {
        auth()->logout();

        return redirect()->route('login')->withErrors([
            'email' => 'Your account is banned. Please contact support.',
        ]);
    }

    return redirect()->intended($this->redirectPath());
}

    protected function sendFailedLoginResponse(Request $request)
{
    $user = \App\Models\User::where('email', $request->email)->first();

    if ($user && $user->status == 0) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => ['Your account is banned. Please contact support.'],
        ]);
    }

    throw \Illuminate\Validation\ValidationException::withMessages([
        'email' => [trans('auth.failed')],
    ]);
}

public function toggleUserStatus($id)
{
    $user = User::findOrFail($id);
    $user->status = !$user->status;
    $user->save();

    return response()->json([
        'success' => true,
        'status' => $user->status,
    ]);
}


}

