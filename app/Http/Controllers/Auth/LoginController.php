<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $isEmail = strpos($username, '@') !== false;

        if ($isEmail) {
            // Admin login dengan email dan password
            $credentials = $request->validate([
                'username' => ['required', 'email'],
                'password' => ['required'],
            ]);

            // Coba autentikasi admin dengan email
            if (Auth::attempt([
                'email' => $credentials['username'],
                'password' => $credentials['password'],
            ])) {
                $user = Auth::user();
                if ($user->role === 'admin') {
                    $request->session()->regenerate();
                    return redirect()->intended(route('admin.dashboard'));
                } else {
                    Auth::logout();
                    return back()->withErrors([
                        'username' => 'Email ini bukan akun admin.',
                    ])->onlyInput('username');
                }
            }

            return back()->withErrors([
                'username' => 'Email atau password admin tidak cocok.',
            ])->onlyInput('username');
        } else {
            // User login dengan nama, kelas, jurusan dan password
            $credentials = $request->validate([
                'username' => ['required', 'string'],
                'password' => ['required'],
                'kelas' => ['required', 'string'],
                'jurusan' => ['required', 'string'],
            ]);

            // Coba autentikasi user
            if (Auth::attempt([
                'name' => $credentials['username'],
                'password' => $credentials['password'],
                'kelas' => $credentials['kelas'],
                'jurusan' => $credentials['jurusan'],
            ])) {
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard'));
            }

            return back()->withErrors([
                'username' => 'Nama, password, kelas, atau jurusan tidak cocok.',
            ])->onlyInput('username', 'kelas', 'jurusan');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
