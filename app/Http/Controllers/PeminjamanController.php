<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanBuku;
use App\Models\BookStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display list buku yang tersedia untuk dipinjam
     */
    public function index()
    {
        $bookStocks = BookStock::where('stok_saat_ini', '>', 0)
            ->paginate(12);

        return view('perpustakaan.pinjam', compact('bookStocks'));
    }

    /**
     * Display riwayat peminjaman user
     */
    public function riwayat()
    {
        $userId = Auth::id();
        $peminjaman = PeminjamanBuku::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('perpustakaan.riwayat', compact('peminjaman'));
    }

    /**
     * Process peminjaman buku
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_stock_id' => 'required|exists:book_stocks,id',
            'tanggal_kembali_rencana' => 'required|date|after:today',
            'catatan' => 'nullable|string|max:255',
        ]);

        $stock = BookStock::findOrFail($validated['book_stock_id']);

        // Check stok tersedia
        if ($stock->stok_saat_ini <= 0) {
            return back()->with('error', 'Stok buku tidak tersedia');
        }

        // Create peminjaman
        $peminjaman = PeminjamanBuku::create([
            'user_id' => Auth::id(),
            'book_stock_id' => $stock->id,
            'kategori' => $stock->kategori,
            'judul_buku' => $stock->judul_buku,
            'tanggal_peminjaman' => now(),
            'tanggal_kembali_rencana' => $validated['tanggal_kembali_rencana'],
            'status' => 'dipinjam',
            'catatan' => $validated['catatan'] ?? null,
        ]);

        // Kurangi stok
        $stock->kurangiStokKeluar(1, 'Dipinjam oleh ' . Auth::user()->name);

        return redirect()->route('perpustakaan.riwayat')
            ->with('success', 'Buku berhasil dipinjam! Rencana pengembalian: ' . $peminjaman->tanggal_kembali_rencana->format('d M Y'));
    }

    /**
     * Tampilkan detail peminjaman
     */
    public function show($id)
    {
        $peminjaman = PeminjamanBuku::where('user_id', Auth::id())
            ->findOrFail($id);

        return view('perpustakaan.detail-pinjam', compact('peminjaman'));
    }

    /**
     * Request pengembalian buku
     */
    public function requestReturn($id)
    {
        $peminjaman = PeminjamanBuku::where('user_id', Auth::id())
            ->findOrFail($id);

        if ($peminjaman->status !== 'dipinjam') {
            return back()->with('error', 'Hanya peminjaman yang aktif bisa dikembalikan');
        }

        $peminjaman->markAsReturned();

        return redirect()->route('perpustakaan.riwayat')
            ->with('success', 'Buku berhasil dikembalikan!');
    }

    /**
     * Report buku hilang
     */
    public function reportLost(Request $request, $id)
    {
        $validated = $request->validate([
            'catatan' => 'required|string|min:10|max:500',
        ]);

        $peminjaman = PeminjamanBuku::where('user_id', Auth::id())
            ->findOrFail($id);

        if ($peminjaman->status !== 'dipinjam') {
            return back()->with('error', 'Hanya peminjaman yang aktif bisa dilaporkan hilang');
        }

        $peminjaman->markAsLost($validated['catatan']);

        return redirect()->route('perpustakaan.riwayat')
            ->with('success', 'Buku berhasil dilaporkan hilang. Admin akan segera menghubungi Anda.');
    }
}
