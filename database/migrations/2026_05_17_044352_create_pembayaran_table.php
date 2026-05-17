<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update enum pembayaran_status di les_privat (tambah 'menunggu')
        \DB::statement("ALTER TABLE les_privat MODIFY pembayaran_status ENUM('belum','menunggu','lunas') DEFAULT 'belum'");

        // Buat tabel pembayaran
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('les_privat_id');
            $table->uuid('siswa_id');
            $table->uuid('tutor_id');
            $table->string('nomor_invoice')->unique();
            $table->integer('jumlah');
            $table->string('bank_tujuan')->nullable();
            $table->string('nomor_rekening_tujuan')->nullable();
            $table->string('bukti_transfer')->nullable();
            $table->enum('status', ['menunggu', 'dikonfirmasi', 'ditolak'])->default('menunggu');
            $table->text('catatan_tutor')->nullable();
            $table->timestamp('dikonfirmasi_at')->nullable();
            $table->timestamps();

            $table->foreign('les_privat_id')->references('id')->on('les_privat')->onDelete('cascade');
            $table->foreign('siswa_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tutor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
        \DB::statement("ALTER TABLE les_privat MODIFY pembayaran_status ENUM('belum','lunas') DEFAULT 'belum'");
    }
};