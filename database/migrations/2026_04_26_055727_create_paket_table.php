<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paket', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->enum('tipe', ['sd', 'smp', 'sma']);
            $table->integer('harga_min');
            $table->integer('harga_max')->nullable();
            $table->integer('jumlah_soal')->nullable();
            $table->integer('jumlah_les')->nullable();
            $table->boolean('feedback_tutor')->default(false);
            $table->boolean('akses_penuh')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paket');
    }
};