<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'Al Ilmi Center')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>

  <style>
    :root {
      --primary:       #1e3a5f;
      --primary-light: #2d5282;
      --accent:        #f6ad3c;
      --bg:            #f1f5f9;
      --card-bg:       #ffffff;
      --text:          #1e293b;
      --muted:         #64748b;
      --border:        #e2e8f0;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      display: flex;
    }

    /* ── KIRI (ilustrasi) ── */
    .auth-left {
      width: 50%;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 60%, #3b6fa0 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 48px;
      position: relative;
      overflow: hidden;
    }
    .auth-left::before {
      content: '';
      position: absolute; top: -60px; right: -60px;
      width: 300px; height: 300px;
      background: rgba(255,255,255,.05);
      border-radius: 50%;
    }
    .auth-left::after {
      content: '';
      position: absolute; bottom: -80px; left: -40px;
      width: 350px; height: 350px;
      background: rgba(255,255,255,.04);
      border-radius: 50%;
    }
    .auth-left-content { position: relative; z-index: 1; text-align: center; }
    .auth-logo {
      width: 64px; height: 64px; background: var(--accent); border-radius: 16px;
      display: flex; align-items: center; justify-content: center;
      font-size: 28px; color: var(--primary); font-weight: 800;
      margin: 0 auto 20px;
    }
    .auth-brand { color: #fff; font-size: 26px; font-weight: 800; margin-bottom: 8px; }
    .auth-tagline { color: rgba(255,255,255,.65); font-size: 14px; max-width: 300px; line-height: 1.6; }

    .auth-features { margin-top: 40px; display: flex; flex-direction: column; gap: 14px; }
    .auth-feature {
      display: flex; align-items: center; gap: 12px;
      background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12);
      padding: 12px 16px; border-radius: 12px;
    }
    .auth-feature-icon {
      width: 36px; height: 36px; background: var(--accent); border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      color: var(--primary); font-size: 16px; flex-shrink: 0;
    }
    .auth-feature-text { color: #fff; font-size: 13px; font-weight: 500; }
    .auth-feature-sub  { color: rgba(255,255,255,.5); font-size: 11px; margin-top: 2px; }

    /* ── KANAN (form) ── */
    .auth-right {
      width: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 48px;
      background: var(--card-bg);
    }
    .auth-box { width: 100%; max-width: 420px; }
    .auth-title { font-size: 24px; font-weight: 800; color: var(--text); margin-bottom: 6px; }
    .auth-sub   { font-size: 13.5px; color: var(--muted); margin-bottom: 28px; }

    /* Form */
    .form-label-custom {
      font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px;
    }
    .form-control-custom {
      width: 100%; padding: 11px 14px; border: 1.5px solid var(--border);
      border-radius: 10px; font-size: 13.5px; font-family: 'Plus Jakarta Sans', sans-serif;
      color: var(--text); background: #fff; transition: all .2s; outline: none;
    }
    .form-control-custom:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(30,58,95,.08);
    }
    .input-wrap { position: relative; }
    .input-icon {
      position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
      color: var(--muted); font-size: 15px;
    }
    .input-wrap .form-control-custom { padding-left: 38px; }
    .input-toggle {
      position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
      color: var(--muted); font-size: 15px; cursor: pointer;
    }

    .btn-primary-custom {
      width: 100%; padding: 12px; border: none; border-radius: 10px;
      background: var(--primary); color: #fff;
      font-size: 14px; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif;
      cursor: pointer; transition: all .2s;
    }
    .btn-primary-custom:hover { background: var(--primary-light); }

    .divider {
      display: flex; align-items: center; gap: 12px;
      margin: 20px 0; color: var(--muted); font-size: 12px;
    }
    .divider::before, .divider::after {
      content: ''; flex: 1; height: 1px; background: var(--border);
    }

    .auth-link { color: var(--primary); font-weight: 600; text-decoration: none; }
    .auth-link:hover { text-decoration: underline; }

    /* Responsive */
    @media (max-width: 768px) {
      .auth-left  { display: none; }
      .auth-right { width: 100%; }
    }
  </style>

  @stack('styles')
</head>
<body>

  {{-- Kiri: Ilustrasi --}}
  <div class="auth-left">
    <div class="auth-left-content">
      <div class="auth-logo">A</div>
      <div class="auth-brand">Al Ilmi Center</div>
      <div class="auth-tagline">
        Platform bimbingan belajar berbasis web untuk persiapan Tes Kemampuan Akademik (TKA)
      </div>

      <div class="auth-features">
        <div class="auth-feature">
          <div class="auth-feature-icon"><i class="bi bi-book-fill"></i></div>
          <div>
            <div class="auth-feature-text">Latihan Soal TKA</div>
            <div class="auth-feature-sub">Soal terstruktur SD, SMP, SMA</div>
          </div>
        </div>
        <div class="auth-feature">
          <div class="auth-feature-icon"><i class="bi bi-person-video3"></i></div>
          <div>
            <div class="auth-feature-text">Les Privat Fleksibel</div>
            <div class="auth-feature-sub">Online maupun tatap muka</div>
          </div>
        </div>
        <div class="auth-feature">
          <div class="auth-feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
          <div>
            <div class="auth-feature-text">Pantau Progres Belajar</div>
            <div class="auth-feature-sub">Lacak perkembangan akademik</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Kanan: Form --}}
<div class="auth-right">
    <div class="auth-box">
        {{ $slot }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>