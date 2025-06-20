<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/dashboard';

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

    protected function guard()
    {
        $role = request()->input('role', 'web');
        $validGuards = ['web', 'formateurs', 'responsables'];
        if (!in_array($role, $validGuards)) {
            $role = 'web';
        }
        return Auth::guard($role);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'role' => 'required|string|in:web,formateurs,responsables',
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        if ($request->input('role') === 'formateurs') {
            Auth::guard('formateurs')->login($user);
            $request->session()->regenerate();
            return redirect()->route('formateur.dashboard');
        } elseif ($request->input('role') === 'responsables') {
            Auth::guard('responsables')->login($user);
            $request->session()->regenerate();
            return redirect()->route('responsable.dashboard');
        }
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $role = $request->input('role', 'web');
        Auth::guard($role)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    protected function attemptLogin(Request $request)
    {
        $guard = $request->input('role', 'web'); // Default to web if role is missing
        return Auth::guard($guard)->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }
}
