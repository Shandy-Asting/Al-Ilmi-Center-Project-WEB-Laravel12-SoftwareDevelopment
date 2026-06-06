<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->json('mata_pelajaran_tutor')->nullable()->after('mode_mengajar');
            $table->json('jenjang_tutor')->nullable()->after('mata_pelajaran_tutor');
            $table->unsignedInteger('tarif_per_sesi')->nullable()->after('jenjang_tutor');
            $table->unsignedTinyInteger('maks_siswa_per_hari')->nullable()->after('tarif_per_sesi');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['mata_pelajaran_tutor', 'jenjang_tutor', 'tarif_per_sesi', 'maks_siswa_per_hari']);
        });
    }
};