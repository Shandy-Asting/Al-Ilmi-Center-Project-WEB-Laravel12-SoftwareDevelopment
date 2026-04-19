@extends('layouts.auth')

@section('title', 'Daftar - Al Ilmi Center')

@section('content')
  <div class="auth-title">Buat Akun Baru 🚀</div>
  <div class="auth-sub">Bergabung dengan Al Ilmi Center sekarang</div>

  <form>
    {{-- Nama Lengkap --}}
    <div class="mb-3">
      <div class="form-label-custom">Nama Lengkap</div>
      <div class="input-wrap">
        <i class="bi bi-person input-icon"></i>
        <input type="text" class="form-control-custom" placeholder="Masukkan nama lengkap"/>
      </div>
    </div>

    {{-- Email --}}
    <div class="mb-3">
      <div class="form-label-custom">Email</div>
      <div class="input-wrap">
        <i class="bi bi-envelope input-icon"></i>
        <input type="email" class="form-control-custom" placeholder="contoh@email.com"/>
      </div>
    </div>

    {{-- No HP --}}
    <div class="mb-3">
      <div class="form-label-custom">No. HP</div>
      <div class="input-wrap">
        <i class="bi bi-telephone input-icon"></i>
        <input type="text" class="form-control-custom" placeholder="08xxxxxxxxxx"/>
      </div>
    </div>

    {{-- Role --}}
    <div class="mb-3">
      <div class="form-label-custom">Daftar Sebagai</div>
      <div class="input-wrap">
        <i class="bi bi-people input-icon"></i>
        <select class="form-control-custom">
          <option value="">-- Pilih Role --</option>
          <option value="siswa">Siswa</option>
          <option value="tutor">Tutor</option>
        </select>
      </div>
    </div>

    {{-- Password --}}
    <div class="mb-3">
      <div class="form-label-custom">Password</div>
      <div class="input-wrap">
        <i class="bi bi-lock input-icon"></i>
        <input type="password" class="form-control-custom" placeholder="Minimal 8 karakter"/>
        <i class="bi bi-eye input-toggle"></i>
      </div>
    </div>

    {{-- Konfirmasi Password --}}
    <div class="mb-4">
      <div class="form-label-custom">Konfirmasi Password</div>
      <div class="input-wrap">
        <i class="bi bi-lock-fill input-icon"></i>
        <input type="password" class="form-control-custom" placeholder="Ulangi password"/>
        <i class="bi bi-eye input-toggle"></i>
      </div>
    </div>

    <button type="submit" class="btn-primary-custom">
      <i class="bi bi-person-plus me-2"></i> Daftar Sekarang
    </button>
  </form>

  <div class="divider">atau</div>

  <div style="text-align:center;font-size:13px;color:var(--muted)">
    Sudah punya akun?
    <a href="/login" class="auth-link">Masuk di sini</a>
  </div>
@endsection