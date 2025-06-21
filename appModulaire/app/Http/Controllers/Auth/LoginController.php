<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth:web,formateurs,responsables')->only('logout');
    }

    protected function guard()
    {
        // This method is less relevant with the new approach, but keep for compatibility
        $role = request()->input('role', 'web');
        $validGuards = ['web', 'formateurs', 'responsables'];
        return Auth::guard(in_array($role, $validGuards) ? $role : 'web');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'role' => 'nullable|string|in:web,formateurs,responsables', // Make role optional
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        $guards = ['web', 'formateurs', 'responsables'];
        $credentials = $this->credentials($request);

        if ($request->filled('role')) {
            // If role is provided, attempt login with that guard only
            $guard = $request->input('role');
            if (in_array($guard, $guards) && Auth::guard($guard)->attempt($credentials, $request->filled('remember'))) {
                $request->session()->put('auth.guard', $guard);
                return true;
            }
            return false;
        }

        // If no role is provided, try all guards
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->attempt($credentials, $request->filled('remember'))) {
                $request->session()->put('auth.guard', $guard);
                return true;
            }
        }

        return false;
    }

    protected function authenticated(Request $request, $user)
    {
        $role = $request->session()->get('auth.guard', 'web');
        $request->session()->regenerate();

        if ($role === 'formateurs') {
            return redirect()->route('formateur.dashboard');
        } elseif ($role === 'responsables') {
            return redirect()->route('responsable.dashboard');
        }
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $guard = $request->session()->get('auth.guard', 'web');
        Auth::guard($guard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}