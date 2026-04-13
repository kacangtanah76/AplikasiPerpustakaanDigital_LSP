<?php
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\BookStock;

class StockBukuExport implements FromCollection
{
    public function collection()
    {
        return BookStock::select(
            'kategori',
            'judul_buku',
            'stok_awal',
            'stok_masuk',
            'stok_keluar',
            'stok_rusak'
        )->get();
    }
}