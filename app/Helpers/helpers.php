<?php

if (!function_exists('notifAdmin')) {
    function notifAdmin(string $judul, string $pesan, string $tipe, array $opsi = []): void
    {
        $admin = \App\Models\User::where('role', 'admin')->first();
        if (!$admin) return;
        \App\Models\Notifikasi::create([
            'user_id'        => $admin->id,
            'judul'          => $judul,
            'pesan'          => $pesan,
            'tipe'           => $tipe,
            'ikon'           => $opsi['ikon']      ?? 'bi bi-bell-fill',
            'warna'          => $opsi['warna']     ?? 'var(--info-soft)',
            'url_aksi'       => $opsi['url']       ?? null,
            'label_aksi'     => $opsi['label']     ?? null,
            'referensi_id'   => $opsi['ref_id']    ?? null,
            'referensi_tipe' => $opsi['ref_tipe']  ?? null,
        ]);
    }
}