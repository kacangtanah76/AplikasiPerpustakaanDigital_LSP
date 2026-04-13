<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeminjamanBuku extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_bukus';

    protected $fillable = [
        'user_id',
        'book_stock_id',
        'kategori',
        'judul_buku',
        'tanggal_peminjaman',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'status',
        'denda',
        'catatan',
    ];

    protected $casts = [
        'tanggal_peminjaman' => 'datetime',
        'tanggal_kembali_rencana' => 'datetime',
        'tanggal_kembali_aktual' => 'datetime',
        'denda' => 'float',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookStock()
    {
        return $this->belongsTo(BookStock::class, 'book_stock_id');
    }

    // Method untuk get status warna
    public function getStatusWarna()
    {
        return match ($this->status) {
            'dipinjam' => 'warning',
            'dikembalikan' => 'success',
            'hilang' => 'danger',
            default => 'gray',
        };
    }

    // Method untuk check apakah terlambat
    public function isTerlambat()
    {
        if ($this->status === 'dikembalikan' && $this->tanggal_kembali_aktual && $this->tanggal_kembali_rencana) {
            return $this->tanggal_kembali_aktual > $this->tanggal_kembali_rencana;
        }
        
        if ($this->status === 'dipinjam' && $this->tanggal_kembali_rencana) {
            return now() > $this->tanggal_kembali_rencana;
        }
        
        return false;
    }

    // Method untuk get jumlah hari terlambat
    public function getHariTerlambat()
    {
        if ($this->status === 'dikembalikan' && $this->tanggal_kembali_aktual && $this->tanggal_kembali_rencana && $this->tanggal_kembali_aktual > $this->tanggal_kembali_rencana) {
            return $this->tanggal_kembali_aktual->diffInDays($this->tanggal_kembali_rencana);
        }
        
        if ($this->status === 'dipinjam' && $this->tanggal_kembali_rencana && now() > $this->tanggal_kembali_rencana) {
            return now()->diffInDays($this->tanggal_kembali_rencana);
        }
        
        return 0;
    }

    // Method untuk format denda untuk display
    public function getDendaFormatted()
    {
        return 'Rp ' . number_format($this->denda, 0, ',', '.');
    }

    // Method untuk get denda yang belum dibayar (untuk dipinjam status)
    public function getDendaTerhitung()
    {
        if ($this->status === 'dipinjam') {
            return $this->calculateDenda();
        }
        
        return $this->denda;
    }

    // Method untuk get denda yang belum dibayar formatted
    public function getDendaTerhitungFormatted()
    {
        $denda = $this->getDendaTerhitung();
        return 'Rp ' . number_format($denda, 0, ',', '.');
    }

    // Method untuk calculate denda (Rp 5000 per hari)
    public function calculateDenda($hargaPerHari = 5000)
    {
        if (!$this->isTerlambat()) {
            return 0;
        }

        $tanggalKembaliAktual = $this->tanggal_kembali_aktual ?? now();
        $hariTerlambat = $tanggalKembaliAktual->diffInDays($this->tanggal_kembali_rencana);
        
        return $hariTerlambat * $hargaPerHari;
    }

    // Method untuk mark as returned
    public function markAsReturned()
    {
        $this->setAttribute('tanggal_kembali_aktual', now());
        $this->status = 'dikembalikan';
        $this->setAttribute('denda', (float) $this->calculateDenda());
        $this->save();

        // Increment stok di BookStock
        if ($this->bookStock) {
            $this->bookStock->increment('stok_saat_ini');
        }

        return $this;
    }

    // Method untuk mark as lost
    public function markAsLost($catatan = null)
    {
        $this->status = 'hilang';
        $this->catatan = $catatan ?? 'Buku hilang saat peminjaman';
        $this->save();

        // Decrement stok di BookStock
        if ($this->bookStock) {
            $this->bookStock->catatStokHilang(1, 'Hilang saat peminjaman');
        }

        return $this;
    }
}

