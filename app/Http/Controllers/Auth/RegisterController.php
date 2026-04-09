<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'in:X,XI,XII'],
            'jurusan' => ['required', 'string', 'in:AnalisKimia,Farmasi,PPLG'],
            'password' => ['required', 'string', 'min:3', 'confirmed'],
        ]);

        // Generate email otomatis dari nama (untuk kompatibilitas database)
        $email = strtolower(str_replace(' ', '', $validated['name'])) . '@student.local';

        $user = User::create([
            'name' => $validated['name'],
            'email' => $email,
            'kelas' => $validated['kelas'],
            'jurusan' => $validated['jurusan'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        auth()->login($user);

        return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil!');
    }
}
