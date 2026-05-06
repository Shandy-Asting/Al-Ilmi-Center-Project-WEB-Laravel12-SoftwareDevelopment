<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('les_privat', function (Blueprint $table) {
            $table->string('topik')->nullable()->after('mata_pelajaran');
            $table->text('catatan')->nullable()->after('topik');
            $table->integer('durasi_menit')->default(90)->after('catatan');
            $table->string('lokasi')->nullable()->after('durasi_menit');
            $table->integer('harga')->default(75000)->after('lokasi');
            $table->string('link_meeting')->nullable()->after('harga');
            $table->enum('pembayaran_status', ['belum', 'lunas'])->default('belum')->after('link_meeting');
        });
    }

    public function down(): void
    {
        Schema::table('les_privat', function (Blueprint $table) {
            $table->dropColumn([
                'topik','catatan','durasi_menit',
                'lokasi','harga','link_meeting','pembayaran_status'
            ]);
        });
    }
};