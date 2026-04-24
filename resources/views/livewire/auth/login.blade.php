<div>
    <div class="auth-title">Selamat Datang! 👋</div>
    <div class="auth-sub">Masuk ke akun Al Ilmi Center kamu</div>

    <form wire:submit="login">
        <div class="mb-3">
            <div class="form-label-custom">Email</div>
            <div class="input-wrap">
                <i class="bi bi-envelope input-icon"></i>
                <input type="email" wire:model="email" class="form-control-custom" placeholder="contoh@email.com" />
            </div>
            @error('email')
                <span class="text-danger" style="font-size:12px">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <div class="form-label-custom">Password</div>
            <div class="input-wrap" x-data="{ show: false }">
                <i class="bi bi-lock input-icon"></i>

                {{-- Pisahkan x-data dari wire:model dengan x-ref --}}
                <input x-ref="passInput" x-bind:type="show ? 'text' : 'password'" wire:model="password"
                    class="form-control-custom" placeholder="Masukkan password" />

                <i class="bi input-toggle" :class="show ? 'bi-eye-slash' : 'bi-eye'" @click="show = !show"></i>
            </div>
            @error('password')
                <span class="text-danger" style="font-size:12px">{{ $message }}</span>
            @enderror
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
</div>
