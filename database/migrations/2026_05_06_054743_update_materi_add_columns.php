<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materi', function (Blueprint $table) {

            if (!Schema::hasColumn('materi', 'tipe')) {
                $table->enum('tipe', ['pdf', 'video', 'doc', 'ppt', 'quiz'])
                      ->default('pdf')->after('kelas');
            }
            if (!Schema::hasColumn('materi', 'topik')) {
                $table->string('topik')->nullable()->after('tipe');
            }
            if (!Schema::hasColumn('materi', 'file_path')) {
                $table->string('file_path')->nullable()->after('topik');
            }
            if (!Schema::hasColumn('materi', 'file_size')) {
                $table->string('file_size')->nullable()->after('file_path');
            }
            if (!Schema::hasColumn('materi', 'link_video')) {
                $table->string('link_video')->nullable()->after('file_size');
            }
            if (!Schema::hasColumn('materi', 'catatan')) {
                $table->text('catatan')->nullable()->after('link_video');
            }
        });
    }

    public function down(): void
    {
        Schema::table('materi', function (Blueprint $table) {
            $table->dropColumn(['tipe', 'topik', 'file_path', 'file_size', 'link_video', 'catatan']);
        });
    }
};