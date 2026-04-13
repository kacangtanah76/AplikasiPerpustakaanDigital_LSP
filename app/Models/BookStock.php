<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookStock extends Model
{
    use HasFactory;

    protected $table = 'book_stocks';

    protected $fillable = [
        'buku_id',
        'kategori',
        'judul_buku',
        'cover_image',
        'stok_awal',
        'stok_masuk',
        'stok_keluar',
        'stok_hilang',
        'stok_rusak',
        'stok_saat_ini',
        'keterangan',
    ];

    protected $casts = [
        'buku_id' => 'integer',
        'stok_awal' => 'integer',
        'stok_masuk' => 'integer',
        'stok_keluar' => 'integer',
        'stok_hilang' => 'integer',
        'stok_rusak' => 'integer',
        'stok_saat_ini' => 'integer',
    ];

    // Relationship
    public function book()
    {
        return $this->belongsTo(Book::class, 'buku_id');
    }

    // Method untuk tambah stok masuk
    public function tambahStokMasuk($jumlah, $keterangan = null)
    {
        $this->stok_masuk += $jumlah;
        $this->hitungStokSaatIni();
        $this->keterangan = $keterangan ?? "Penambahan stok masuk: {$jumlah} unit";
        $this->save();

        // Update stok di Book model (jika book relationship ada)
        if ($this->book) {
            $this->book->increment('stok_saat_ini', $jumlah);
        }

        return $this;
    }

    // Method untuk kurangi stok keluar (peminjaman)
    public function kurangiStokKeluar($jumlah, $keterangan = null)
    {
        if ($this->stok_saat_ini < $jumlah) {
            throw new \Exception('Stok tidak cukup');
        }

        $this->stok_keluar += $jumlah;
        $this->hitungStokSaatIni();
        $this->keterangan = $keterangan ?? "Pengurangan stok keluar: {$jumlah} unit";
        $this->save();

        // Update stok di Book model (jika book relationship ada)
        if ($this->book) {
            $this->book->decrement('stok_saat_ini', $jumlah);
        }

        return $this;
    }

    // Method untuk catat stok rusak
    public function catatStokRusak($jumlah, $keterangan = null)
    {
        if ($this->stok_saat_ini < $jumlah) {
            throw new \Exception('Stok tidak cukup');
        }

        $this->stok_rusak += $jumlah;
        $this->hitungStokSaatIni();
        $this->keterangan = $keterangan ?? "Buku rusak: {$jumlah} unit";
        $this->save();

        // Update stok di Book model (jika book relationship ada)
        if ($this->book) {
            $this->book->decrement('stok_saat_ini', $jumlah);
        }

        return $this;
    }

    // Method untuk catat stok hilang
    public function catatStokHilang($jumlah, $keterangan = null)
    {
        if ($this->stok_saat_ini < $jumlah) {
            throw new \Exception('Stok tidak cukup');
        }

        $this->stok_hilang += $jumlah;
        $this->hitungStokSaatIni();
        $this->keterangan = $keterangan ?? "Buku hilang: {$jumlah} unit";
        $this->save();

        // Update stok di Book model (jika book relationship ada)
        if ($this->book) {
            $this->book->decrement('stok_saat_ini', $jumlah);
        }

        return $this;
    }

    // Method untuk hitung stok saat ini
    public function hitungStokSaatIni()
    {
        $this->stok_saat_ini = $this->stok_awal + $this->stok_masuk - $this->stok_keluar - $this->stok_rusak - $this->stok_hilang;
        return $this->stok_saat_ini;
    }

    // Method untuk cek status stok
    public function getStatusStok()
    {
        if ($this->stok_saat_ini <= 0) {
            return 'Habis';
        } elseif ($this->stok_saat_ini <= 5) {
            return 'Terbatas';
        }
        return 'Tersedia';
    }

    // Method untuk persentase stok
    public function getPersentaseStok()
    {
        if ($this->stok_awal == 0) {
            return 0;
        }
        return round(($this->stok_saat_ini / $this->stok_awal) * 100, 2);
    }
}

