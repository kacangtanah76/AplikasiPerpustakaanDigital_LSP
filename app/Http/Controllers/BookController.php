<?php

namespace App\Http\Controllers;

use App\Models\BookStock;
use App\Models\PeminjamanBuku;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function infoBuku(Request $request)
    {
        $query = BookStock::query();

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_buku', 'like', "%{$search}%");
            });
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('kategori', $request->category);
        }

        $bookStocks = $query->paginate(15);

        // Statistik Buku
        $totalBooks = BookStock::count();
        $totalStock = BookStock::sum('stok_saat_ini');
        $limitedStock = BookStock::whereBetween('stok_saat_ini', [1, 5])->count();
        $emptyStock = BookStock::where('stok_saat_ini', 0)->count();

        // Statistik Peminjaman
        $peminjamanStats = [
            'aktif' => PeminjamanBuku::where('status', 'dipinjam')->count(),
            'dikembalikan' => PeminjamanBuku::where('status', 'dikembalikan')->count(),
            'hilang' => PeminjamanBuku::where('status', 'hilang')->count(),
        ];

        // Distribusi kategori
        $categoryStats = BookStock::groupBy('kategori')
            ->select('kategori')
            ->selectRaw('count(*) as count')
            ->pluck('count', 'kategori');

        return view('perpustakaan.infoBuku', [
            'bookStocks' => $bookStocks,
            'totalBooks' => $totalBooks,
            'totalStock' => $totalStock,
            'limitedStock' => $limitedStock,
            'emptyStock' => $emptyStock,
            'peminjamanStats' => $peminjamanStats,
            'categoryStats' => $categoryStats,
        ]);
    }
}

