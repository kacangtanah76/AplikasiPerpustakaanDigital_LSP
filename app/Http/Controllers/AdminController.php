<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BookStock;
use App\Models\PeminjamanBuku;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Verifikasi bahwa user adalah admin
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('dashboard');
        }

        // User Statistics
        $totalUsers = User::where('role', 'user')->count();
        $totalAdmin = User::where('role', 'admin')->count();
        $users = User::where('role', 'user')->paginate(10);
        $kelasX = User::where('kelas', 'X')->count();
        $kelasXI = User::where('kelas', 'XI')->count();
        $kelasXII = User::where('kelas', 'XII')->count();

        // Book Statistics
        $totalBooks = BookStock::count();
        $totalStok = BookStock::sum('stok_saat_ini');
        $bukuHabis = BookStock::where('stok_saat_ini', '<=', 0)->count();
        $bukuTerbatas = BookStock::where('stok_saat_ini', '>', 0)
            ->where('stok_saat_ini', '<=', 5)
            ->count();

        // Peminjaman Statistics
        $peminjamanAktif = PeminjamanBuku::where('status', 'dipinjam')->count();
        $peminjamanDikembalikan = PeminjamanBuku::where('status', 'dikembalikan')->count();
        $peminjamanHilang = PeminjamanBuku::where('status', 'hilang')->count();
        $totalPeminjaman = PeminjamanBuku::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmin',
            'users',
            'kelasX',
            'kelasXI',
            'kelasXII',
            'totalBooks',
            'totalStok',
            'bukuHabis',
            'bukuTerbatas',
            'peminjamanAktif',
            'peminjamanDikembalikan',
            'peminjamanHilang',
            'totalPeminjaman'
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
