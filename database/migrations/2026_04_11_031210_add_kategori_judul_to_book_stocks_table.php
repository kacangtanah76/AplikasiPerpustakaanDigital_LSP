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
        Schema::table('book_stocks', function (Blueprint $table) {
            $table->string('kategori')->default('Pendidikan')->after('buku_id');
            $table->string('judul_buku')->nullable()->after('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_stocks', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'judul_buku']);
        });
    }
};
