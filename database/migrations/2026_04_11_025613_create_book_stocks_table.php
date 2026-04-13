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
        Schema::create('book_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_id')->constrained('books')->onDelete('cascade');
            $table->integer('stok_awal')->default(0);
            $table->integer('stok_masuk')->default(0);
            $table->integer('stok_keluar')->default(0);
            $table->integer('stok_hilang')->default(0);
            $table->integer('stok_rusak')->default(0);
            $table->integer('stok_saat_ini')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index('buku_id');
            $table->index('stok_saat_ini');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_stocks');
    }
};
