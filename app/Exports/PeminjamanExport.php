<?php
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Peminjaman;

class PeminjamanExport implements FromCollection
{
    public function collection()
    {
        return Peminjaman::with('user', 'book')
            ->get()
            ->map(function ($item) {
                return [
                    'Nama' => $item->user->name,
                    'Buku' => $item->book->judul_buku,
                    'Tanggal Pinjam' => $item->tanggal_pinjam,
                    'Tanggal Kembali' => $item->tanggal_kembali,
                    'Status' => $item->status,
                ];
            });
    }
}