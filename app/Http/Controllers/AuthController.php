<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        $fromFrontend = $request->get('from') === 'frontend';

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($fromFrontend) {
            return redirect()->route('frontend.home');
        }

        return redirect()->route('login');
    }

    /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        $roles = Role::orderBy('name')->get();
        $opds = Opd::orderBy('name')->get();

        return view('auth.register', compact('roles', 'opds'));
    }

    /**
     * Handle a new user registration.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
            'opd_id' => ['nullable', 'exists:opds,id'],
        ]);

        $opdName = null;
        if (! empty($validated['opd_id'])) {
            $opdName = Opd::findOrFail($validated['opd_id'])->name;
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'opd' => $opdName,
        ]);

        $role = Role::findById($validated['role_id']);
        $user->assignRole($role);

        Auth::login($user);

        return redirect('/dashboard');
    }

    /**
     * Show the frontend login form.
     */
    public function showFrontendLoginForm()
    {
        return view('frontend.auth.login');
    }

    /**
     * Handle a frontend authentication attempt.
     */
    public function frontendLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('frontend.home'));
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Show the frontend registration form.
     */
    public function showFrontendRegisterForm()
    {
        return view('frontend.auth.register');
    }

    /**
     * Handle a frontend customer registration.
     */
    public function frontendRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $role = Role::firstOrCreate(['name' => 'viewer', 'guard_name' => 'web']);
        $user->assignRole($role);

        Auth::login($user);

        return redirect()->route('frontend.home')->with('success', 'Pendaftaran akun berhasil! Selamat datang di SIFIT.');
    }
}
