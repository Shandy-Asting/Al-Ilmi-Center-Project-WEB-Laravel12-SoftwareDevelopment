<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Paket;
use App\Models\RekeningBank;


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // ── Halaman Statis ─────────────────────────────────────────────────────
    Route::get('/dashboard',  fn () => view('admin.dashboard'));
    Route::get('/pengguna',   fn () => view('admin.pengguna'));
    Route::get('/transaksi',  fn () => view('admin.transaksi'));
    Route::get('/pembayaran', fn () => view('admin.pembayaran'));
    Route::get('/laporan',    fn () => view('admin.laporan'));
    Route::get('/notifikasi', function () {
    return view('admin.notifikasi');
});

    // ── Paket ──────────────────────────────────────────────────────────────
    Route::get('/paket', fn () => view('admin.paket'));

    Route::post('/paket', function (Request $request) {
        $request->validate([
            'nama'     => 'required',
            'tipe'     => 'required|in:sd,smp,sma',
            'harga_min' => 'required|numeric',
        ]);

        Paket::create($request->only([
            'nama', 'tipe', 'harga_min', 'harga_max',
            'jumlah_soal', 'jumlah_les', 'feedback_tutor', 'akses_penuh',
        ]));

        return redirect('/admin/paket')->with('sukses', 'Paket berhasil ditambahkan!');
    });

    // ── Rekening Bank ──────────────────────────────────────────────────────
    Route::get('/rekening', function () {
        return view('admin.rekening', [
            'rekening' => RekeningBank::orderBy('created_at', 'desc')->get(),
        ]);
    });

    Route::post('/rekening', function (Request $request) {
        $request->validate([
            'nama_bank'       => 'required',
            'nomor_rekening'  => 'required',
            'atas_nama'       => 'required',
        ]);

        RekeningBank::create($request->only(['nama_bank', 'nomor_rekening', 'atas_nama']));

        return redirect('/admin/rekening')->with('sukses', 'Rekening berhasil ditambahkan!');
    });

    Route::put('/rekening/{id}', function (Request $request, $id) {
        RekeningBank::findOrFail($id)->update(
            $request->only(['nama_bank', 'nomor_rekening', 'atas_nama'])
        );

        return redirect('/admin/rekening')->with('sukses', 'Rekening berhasil diperbarui!');
    });

    Route::post('/rekening/{id}/toggle', function ($id) {
        $rek = RekeningBank::findOrFail($id);
        $rek->update(['aktif' => ! $rek->aktif]);

        return redirect('/admin/rekening')->with('sukses', 'Status rekening diperbarui!');
    });

    Route::delete('/rekening/{id}', function ($id) {
        RekeningBank::findOrFail($id)->delete();

        return redirect('/admin/rekening')->with('sukses', 'Rekening berhasil dihapus!');
    });
});