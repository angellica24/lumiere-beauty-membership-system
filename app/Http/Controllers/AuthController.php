<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Email atau password salah.');
        }

        $request->session()->regenerate();

        if (!auth()->user()->is_active) {
            Auth::logout();

            return redirect()->route('login')
                ->with('error', 'Akun Anda sedang tidak aktif.');
        }

        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Berhasil login sebagai admin.');
        }

        return redirect()->route('home')
            ->with('success', 'Berhasil login.');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'role' => 'customer',
            'membership_level_id' => 1,
            'total_points' => 0,
            'is_active' => true,
        ]);

        $customerRole = Role::where('name', 'customer')->first();

        if ($customerRole) {
            $user->roles()->syncWithoutDetaching([$customerRole->id]);
        }

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Anda berhasil logout.');
    }
}