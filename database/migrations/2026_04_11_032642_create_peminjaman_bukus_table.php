<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman_bukus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('book_stock_id')->nullable()->constrained('book_stocks')->onDelete('cascade');
            $table->string('kategori')->nullable();
            $table->string('judul_buku');
            $table->dateTime('tanggal_peminjaman')->default(now());
            $table->dateTime('tanggal_kembali_rencana')->nullable();
            $table->dateTime('tanggal_kembali_aktual')->nullable();
            $table->enum('status', ['dipinjam', 'dikembalikan', 'hilang'])->default('dipinjam');
            $table->decimal('denda', 10, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('book_stock_id');
            $table->index('status');
            $table->index('tanggal_peminjaman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_bukus');
    }
};
