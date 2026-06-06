<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('notif_permintaan_jadwal')->default(true)->after('mode_mengajar');
            $table->boolean('notif_pengingat_sesi')->default(true)->after('notif_permintaan_jadwal');
            $table->boolean('notif_pembayaran')->default(true)->after('notif_pengingat_sesi');
            $table->boolean('notif_ulasan')->default(true)->after('notif_pembayaran');
            $table->boolean('notif_newsletter')->default(false)->after('notif_ulasan');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'notif_permintaan_jadwal',
                'notif_pengingat_sesi',
                'notif_pembayaran',
                'notif_ulasan',
                'notif_newsletter',
            ]);
        });
    }
};