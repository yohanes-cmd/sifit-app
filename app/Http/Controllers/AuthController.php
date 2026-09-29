<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt with throttle protection.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $throttleKey = Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
            ]);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        RateLimiter::hit($throttleKey, 60);

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
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
    public function showRegisterForm(): View
    {
        $roles = Role::orderBy('name')->get();
        $opds = Opd::orderBy('nama_opd')->get();

        return view('auth.register', compact('roles', 'opds'));
    }

    /**
     * Handle a new user registration with throttle protection.
     */
    public function register(Request $request): RedirectResponse
    {
        $throttleKey = 'register|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan pendaftaran. Silakan coba lagi dalam {$seconds} detik.",
            ]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
            'opd_id' => ['nullable', 'exists:opds,id'],
        ]);

        $opdName = null;
        if (! empty($validated['opd_id'])) {
            $opd = Opd::find($validated['opd_id']);
            $opdName = $opd ? ($opd->nama_opd ?? $opd->name) : null;
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'opd' => $opdName,
        ]);

        $role = Role::findById($validated['role_id']);
        $user->assignRole($role);

        RateLimiter::clear($throttleKey);
        Auth::login($user);

        return redirect('/dashboard');
    }

    /**
     * Show the frontend login form.
     */
    public function showFrontendLoginForm(): View
    {
        return view('frontend.auth.login');
    }

    /**
     * Handle a frontend authentication attempt with throttle protection.
     */
    public function frontendLogin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $throttleKey = Str::transliterate('frontend|'.Str::lower($request->input('email')).'|'.$request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan masuk. Silakan coba lagi dalam {$seconds} detik.",
            ]);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            return redirect()->intended(route('frontend.home'));
        }

        RateLimiter::hit($throttleKey, 60);

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Show the frontend registration form.
     */
    public function showFrontendRegisterForm(): View
    {
        return view('frontend.auth.register');
    }

    /**
     * Handle a frontend customer registration with throttle protection.
     */
    public function frontendRegister(Request $request): RedirectResponse
    {
        $throttleKey = 'frontend_register|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan pendaftaran. Silakan coba lagi dalam {$seconds} detik.",
            ]);
        }

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

        RateLimiter::clear($throttleKey);
        Auth::login($user);

        return redirect()->route('frontend.home')->with('success', 'Pendaftaran akun berhasil! Selamat datang di SIFIT.');
    }
}
