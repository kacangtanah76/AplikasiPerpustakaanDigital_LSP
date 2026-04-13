<?php
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StockBukuExport;
use App\Exports\PeminjamanExport;

class LaporanController extends Controller
{
    public function exportStock()
    {
        return Excel::download(new StockBukuExport, 'stock_buku.xlsx');
    }

    public function exportPeminjaman()
    {
        return Excel::download(new PeminjamanExport, 'laporan_peminjaman.xlsx');
    }
}