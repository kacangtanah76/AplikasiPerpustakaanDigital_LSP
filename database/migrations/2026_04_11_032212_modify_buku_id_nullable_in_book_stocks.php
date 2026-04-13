<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('book_stocks', function (Blueprint $table) {
            $table->dropForeign(['buku_id']);
        });

        DB::statement('ALTER TABLE book_stocks MODIFY buku_id BIGINT UNSIGNED NULL');

        Schema::table('book_stocks', function (Blueprint $table) {
            $table->foreign('buku_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('book_stocks', function (Blueprint $table) {
            $table->dropForeign(['buku_id']);
        });

        DB::statement('ALTER TABLE book_stocks MODIFY buku_id BIGINT UNSIGNED NOT NULL');

        Schema::table('book_stocks', function (Blueprint $table) {
            $table->foreign('buku_id')->references('id')->on('books')->onDelete('cascade');
        });
    }
};
