<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            Auth::user()->updateStreak();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'প্রদত্ত ইমেইল বা পাসওয়ার্ড সঠিক নয়।',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20|unique:users',
            'target_exam' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'target_exam' => $validated['target_exam'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
            'coins' => 100,
            'daily_streak' => 1,
            'longest_streak' => 1,
            'last_active_date' => now()->toDateString(),
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'স্বাগতম ტার্গেট অফিসার প্ল্যাটফর্মে!');
    }

    public function demoLogin(Request $request, $type = 'student')
    {
        $email = $type === 'admin' ? 'admin@targetofficer.com' : 'candidate@targetofficer.com';
        $user = User::where('email', $email)->first();

        if ($user) {
            Auth::login($user);
            $user->updateStreak();
            return redirect()->route('dashboard')->with('success', 'ডেমো ইউজার হিসেবে লগইন সম্পন্ন হয়েছে!');
        }

        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
