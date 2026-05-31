<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('pendidikan')->nullable()->after('bio');
            $table->string('jurusan')->nullable()->after('pendidikan');
            $table->integer('tahun_mengajar')->nullable()->after('jurusan');
            $table->string('mode_mengajar')->nullable()->after('tahun_mengajar');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['pendidikan', 'jurusan', 'tahun_mengajar', 'mode_mengajar']);
        });
    }
};