@extends('layouts.auth')
@section('title', 'Daftar - Al Ilmi Center')
@section('content')
  <div class="auth-title">Buat Akun Baru 🚀</div>
  <div class="auth-sub">Bergabung dengan Al Ilmi Center sekarang</div>

  <form wire:submit.prevent="register">
    @csrf
    {{-- Nama Lengkap --}}
    <div class="mb-3">
      <div class="form-label-custom">Nama Lengkap</div>
      <div class="input-wrap">
        <i class="bi bi-person input-icon"></i>
        <input type="text" class="form-control-custom" placeholder="Masukkan nama lengkap" wire:model="name"/>
      </div>
      @error('name') <span class="text-danger" style="font-size:12px">{{ $message }}</span> @enderror
    </div>

    {{-- Email --}}
    <div class="mb-3">
      <div class="form-label-custom">Email</div>
      <div class="input-wrap">
        <i class="bi bi-envelope input-icon"></i>
        <input type="email" class="form-control-custom" placeholder="contoh@email.com" wire:model="email"/>
      </div>
      @error('email') <span class="text-danger" style="font-size:12px">{{ $message }}</span> @enderror
    </div>

    {{-- No HP --}}
    <div class="mb-3">
      <div class="form-label-custom">No. HP</div>
      <div class="input-wrap">
        <i class="bi bi-telephone input-icon"></i>
        <input type="text" class="form-control-custom" placeholder="08xxxxxxxxxx" wire:model="no_hp"/>
      </div>
      @error('no_hp') <span class="text-danger" style="font-size:12px">{{ $message }}</span> @enderror
    </div>

    {{-- Role --}}
    <div class="mb-3">
      <div class="form-label-custom">Daftar Sebagai</div>
      <div class="input-wrap">
        <i class="bi bi-people input-icon"></i>
        <select class="form-control-custom" wire:model="role">
          <option value="">-- Pilih Role --</option>
          <option value="siswa">Siswa</option>
          <option value="tutor">Tutor</option>
        </select>
      </div>
      @error('role') <span class="text-danger" style="font-size:12px">{{ $message }}</span> @enderror
    </div>

    {{-- Password --}}
    <div class="mb-3">
      <div class="form-label-custom">Password</div>
      <div class="input-wrap">
        <i class="bi bi-lock input-icon"></i>
        <input type="password" class="form-control-custom" placeholder="Minimal 8 karakter" wire:model="password"/>
        <i class="bi bi-eye input-toggle"></i>
      </div>
      @error('password') <span class="text-danger" style="font-size:12px">{{ $message }}</span> @enderror
    </div>

    {{-- Konfirmasi Password --}}
    <div class="mb-4">
      <div class="form-label-custom">Konfirmasi Password</div>
      <div class="input-wrap">
        <i class="bi bi-lock-fill input-icon"></i>
        <input type="password" class="form-control-custom" placeholder="Ulangi password" wire:model="password_confirmation"/>
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