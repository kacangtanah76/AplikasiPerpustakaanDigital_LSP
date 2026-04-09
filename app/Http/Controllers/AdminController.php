<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Verifikasi bahwa user adalah admin
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('dashboard');
        }

        $totalUsers = User::where('role', 'user')->count();
        $totalAdmin = User::where('role', 'admin')->count();
        $users = User::where('role', 'user')->paginate(10);
        $kelasX = User::where('kelas', 'X')->count();
        $kelasXI = User::where('kelas', 'XI')->count();
        $kelasXII = User::where('kelas', 'XII')->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmin',
            'users',
            'kelasX',
            'kelasXI',
            'kelasXII'
        ));
    }

    public function users()
    {
        // Verifikasi bahwa user adalah admin
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('dashboard');
        }

        $users = User::paginate(20);
        return view('admin.users', compact('users'));
    }
}
