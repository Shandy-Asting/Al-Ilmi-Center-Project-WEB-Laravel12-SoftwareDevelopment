<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_kuis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('materi_id');
            $table->integer('nilai')->default(0);
            $table->integer('soal_benar')->default(0);
            $table->integer('soal_salah')->default(0);
            $table->integer('total_soal')->default(0);
            $table->integer('durasi_menit')->default(0);
            $table->enum('tipe', ['latihan', 'kuis'])->default('latihan');
            $table->json('jawaban')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('materi_id')->references('id')->on('materi')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_kuis');
    }
};