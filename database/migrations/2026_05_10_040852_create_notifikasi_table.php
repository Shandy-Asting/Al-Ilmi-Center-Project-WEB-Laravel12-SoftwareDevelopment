<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('judul');
            $table->text('pesan');
            $table->enum('tipe', ['les_privat','pembayaran','belajar','sistem','ulasan','streak'])->default('sistem');
            $table->string('ikon')->nullable();
            $table->string('warna')->nullable();
            $table->string('url_aksi')->nullable();
            $table->string('label_aksi')->nullable();
            $table->boolean('sudah_dibaca')->default(false);
            $table->uuid('referensi_id')->nullable();
            $table->string('referensi_tipe')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'sudah_dibaca']);
            $table->index(['user_id', 'tipe']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};