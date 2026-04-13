<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('tipe_transaksi', ['masuk', 'keluar', 'pengembalian', 'rusak']);
            $table->integer('stok');
            $table->text('catatan')->nullable();
            $table->dateTime('tanggal_transaksi')->default(now());
            $table->timestamps();

            $table->index('buku_id');
            $table->index('user_id');
            $table->index('tipe_transaksi');
            $table->index('tanggal_transaksi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_transactions');
    }
};
