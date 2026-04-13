<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('author');
            $table->string('penerbit')->nullable();
            $table->integer('tahun_rilis')->nullable();
            $table->string('kategori')->default('Umum');
            $table->integer('stok_awal')->default(0);
            $table->integer('stok_saat_ini')->default(0);
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();

            $table->index('judul');
            $table->index('author');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
