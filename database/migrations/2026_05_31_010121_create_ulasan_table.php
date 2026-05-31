<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('les_privat_id');
            $table->uuid('siswa_id');
            $table->uuid('tutor_id');
            $table->tinyInteger('bintang');
            $table->text('komentar')->nullable();
            $table->timestamps();

            $table->foreign('les_privat_id')->references('id')->on('les_privat')->onDelete('cascade');
            $table->foreign('siswa_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tutor_id')->references('id')->on('users')->onDelete('cascade');

            // Satu siswa hanya bisa ulasan satu kali per sesi
            $table->unique('les_privat_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};