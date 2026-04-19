@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('sidebar-sub', 'Admin Panel')
@section('page-title', 'Dashboard Admin')
@section('page-sub', 'Selamat datang kembali!')

@section('sidebar-menu')
    <div class="menu-label">Utama</div>
    <a href="#" class="nav-item-custom active">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <div class="menu-label">Pengelolaan</div>
    <a href="#" class="nav-item-custom">
        <i class="bi bi-people"></i> Pengelolaan Pengguna
    </a>
    <a href="#" class="nav-item-custom">
        <i class="bi bi-box-seam"></i> Pengelolaan Paket
    </a>
    <a href="#" class="nav-item-custom">
        <i class="bi bi-credit-card"></i> Transaksi
    </a>
    <a href="#" class="nav-item-custom">
        <i class="bi bi-bar-chart-line"></i> Laporan
    </a>
@endsection

@section('content')
    <h3>Halo! Layout berhasil! ✅</h3>
@endsection