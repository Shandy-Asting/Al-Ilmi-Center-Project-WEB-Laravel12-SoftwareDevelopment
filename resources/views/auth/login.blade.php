@extends('layouts.auth')

@section('title', 'Login - Al Ilmi Center')

@section('content')
  <div class="auth-title">Selamat Datang! 👋</div>
  <div class="auth-sub">Masuk ke akun Al Ilmi Center kamu</div>

  <form>
    <div class="mb-3">
      <div class="form-label-custom">Email</div>
      <div class="input-wrap">
        <i class="bi bi-envelope input-icon"></i>
        <input type="email" class="form-control-custom" placeholder="contoh@email.com"/>
      </div>
    </div>

    <div class="mb-4">
      <div class="form-label-custom">Password</div>
      <div class="input-wrap">
        <i class="bi bi-lock input-icon"></i>
        <input type="password" class="form-control-custom" placeholder="Masukkan password"/>
        <i class="bi bi-eye input-toggle"></i>
      </div>
    </div>

    <button type="submit" class="btn-primary-custom">
      <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
    </button>
  </form>

  <div class="divider">atau</div>

  <div style="text-align:center;font-size:13px;color:var(--muted)">
    Belum punya akun?
    <a href="/register" class="auth-link">Daftar sekarang</a>
  </div>
@endsection