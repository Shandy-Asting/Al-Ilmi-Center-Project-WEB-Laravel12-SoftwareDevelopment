<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gaji_tutor', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tutor_id');
            $table->integer('total_sesi');
            $table->integer('total_pendapatan');
            $table->integer('komisi_platform'); // 20%
            $table->integer('total_diterima');  // 80%
            $table->string('periode');          // "Mei 2026"
            $table->enum('status', ['menunggu', 'dikonfirmasi', 'ditunda'])->default('menunggu');
            $table->text('catatan')->nullable();
            $table->timestamp('dikonfirmasi_at')->nullable();
            $table->timestamps();

            $table->foreign('tutor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gaji_tutor');
    }
};