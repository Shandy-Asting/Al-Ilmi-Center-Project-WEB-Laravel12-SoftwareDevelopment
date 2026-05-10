<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('no_hp');
            $table->date('tanggal_lahir')->nullable()->after('avatar');
            $table->string('jenjang')->nullable()->after('tanggal_lahir');   // sd|smp|sma
            $table->string('kelas')->nullable()->after('jenjang');
            $table->string('kota')->nullable()->after('kelas');
            $table->string('provinsi')->nullable()->after('kota');
            $table->string('tujuan_belajar')->nullable()->after('provinsi');
            $table->text('bio')->nullable()->after('tujuan_belajar');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar',
                'tanggal_lahir',
                'jenjang',
                'kelas',
                'kota',
                'provinsi',
                'tujuan_belajar',
                'bio',
            ]);
        });
    }
    protected $fillable = [
        'name',
        'email',
        'password',
        'no_hp',
        'role',
        'avatar',
        'tanggal_lahir',
        'jenjang',
        'kelas',
        'kota',
        'provinsi',
        'tujuan_belajar',
        'bio',
    ];
};
