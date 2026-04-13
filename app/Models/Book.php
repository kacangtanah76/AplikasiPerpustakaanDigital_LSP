<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'author',
        'penerbit',
        'tahun_rilis',
        'kategori',
        'stok_awal',
        'stok_saat_ini',
        'deskripsi',
        'gambar',
    ];

    protected $casts = [
        'tahun_rilis' => 'integer',
        'stok_awal' => 'integer',
        'stok_saat_ini  ' => 'integer',
    ];

    public function transactions()
    {
        return $this->hasMany(BookTransaction::class);
    }

    public function stock()
    {
        return $this->hasOne(BookStock::class, 'buku_id');
    }

    public function getStockStatusAttribute()
    {
        if ($this->stok_saat_ini <= 0) {
            return 'Habis';
        } elseif ($this->stok_saat_ini <= 5) {
            return 'Terbatas';
        }
        return 'Tersedia';
    }
}
