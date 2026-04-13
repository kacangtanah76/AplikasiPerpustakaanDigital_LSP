<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'buku_id',
        'user_id',
        'tipe_transaksi',
        'stok',
        'catatan',
        'tanggal_transaksi',
    ];

    protected $casts = [
        'stok' => 'integer',
        'tanggal_transaksi' => 'datetime',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
