<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Al Ilmi Center - Bimbel TKA</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

  <style>
    :root {
      --primary: #1e3a5f;
      --primary-light: #2d5282;
      --accent: #f6ad3c;
      --accent-soft: #fef3dc;
      --success: #16a34a;
      --success-soft: #dcfce7;
      --bg: #f1f5f9;
      --text: #1e293b;
      --muted: #64748b;
      --border: #e2e8f0;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: var(--text);
      background: #fff;
    }

    /* ── NAVBAR ── */
    .navbar-custom {
      background: #fff;
      border-bottom: 1px solid var(--border);
      padding: 12px 0;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .navbar-brand-custom {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
    }

    .nav-logo {
      width: 36px;
      height: 36px;
      background: var(--primary);
      border-radius: 9px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--accent);
      font-weight: 800;
      font-size: 16px;
      flex-shrink: 0;
    }

    .nav-brand-name {
      font-size: 17px;
      font-weight: 800;
      color: var(--primary);
    }

    .nav-link-custom {
      color: var(--muted);
      font-size: 14px;
      font-weight: 500;
      text-decoration: none;
      padding: 6px 12px;
      border-radius: 8px;
      transition: all .2s;
    }

    .nav-link-custom:hover {
      color: var(--primary);
      background: var(--bg);
    }

    .btn-nav-login {
      border: 1.5px solid var(--primary);
      color: var(--primary);
      background: transparent;
      padding: 7px 16px;
      border-radius: 8px;
      font-size: 13.5px;
      font-weight: 600;
      cursor: pointer;
      transition: all .2s;
      text-decoration: none;
      white-space: nowrap;
    }

    .btn-nav-login:hover {
      background: var(--primary);
      color: #fff;
    }

    .btn-nav-daftar {
      background: var(--primary);
      color: #fff;
      padding: 7px 16px;
      border-radius: 8px;
      font-size: 13.5px;
      font-weight: 600;
      cursor: pointer;
      transition: all .2s;
      text-decoration: none;
      border: none;
      white-space: nowrap;
    }

    .btn-nav-daftar:hover {
      background: var(--primary-light);
      color: #fff;
    }

    /* Mobile Nav Toggle */
    .hamburger {
      display: none;
      flex-direction: column;
      gap: 5px;
      cursor: pointer;
      padding: 4px;
      background: none;
      border: none;
    }

    .hamburger span {
      display: block;
      width: 24px;
      height: 2px;
      background: var(--primary);
      border-radius: 2px;
      transition: all .3s;
    }

    .hamburger.open span:nth-child(1) {
      transform: translateY(7px) rotate(45deg);
    }

    .hamburger.open span:nth-child(2) {
      opacity: 0;
    }

    .hamburger.open span:nth-child(3) {
      transform: translateY(-7px) rotate(-45deg);
    }

    .mobile-menu {
      display: none;
      background: #fff;
      border-top: 1px solid var(--border);
      padding: 16px 20px 20px;
      flex-direction: column;
      gap: 6px;
    }

    .mobile-menu.open {
      display: flex;
    }

    .mobile-menu .nav-link-custom {
      padding: 10px 12px;
    }

    .mobile-menu .btn-nav-login,
    .mobile-menu .btn-nav-daftar {
      text-align: center;
      padding: 10px;
    }

    /* ── HERO ── */
    .hero {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 60%, #3b6fa0 100%);
      padding: 60px 0 48px;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      top: -80px;
      right: -80px;
      width: 400px;
      height: 400px;
      background: rgba(255, 255, 255, .04);
      border-radius: 50%;
    }

    .hero::after {
      content: '';
      position: absolute;
      bottom: -100px;
      left: -60px;
      width: 450px;
      height: 450px;
      background: rgba(255, 255, 255, .03);
      border-radius: 50%;
    }

    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(255, 255, 255, .12);
      border: 1px solid rgba(255, 255, 255, .2);
      color: #fff;
      font-size: 12px;
      font-weight: 600;
      padding: 5px 14px;
      border-radius: 20px;
      margin-bottom: 20px;
    }

    .hero-title {
      color: #fff;
      font-size: 38px;
      font-weight: 800;
      line-height: 1.2;
      margin-bottom: 16px;
    }

    .hero-title span {
      color: var(--accent);
    }

    .hero-sub {
      color: rgba(255, 255, 255, .75);
      font-size: 15px;
      line-height: 1.7;
      margin-bottom: 28px;
    }

    .hero-btns {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
      margin-bottom: 36px;
    }

    .btn-hero-primary {
      background: var(--accent);
      color: var(--primary);
      padding: 12px 24px;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 700;
      text-decoration: none;
      transition: all .2s;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      white-space: nowrap;
    }

    .btn-hero-primary:hover {
      background: #f59e0b;
      color: var(--primary);
    }

    .btn-hero-outline {
      background: rgba(255, 255, 255, .12);
      color: #fff;
      border: 1.5px solid rgba(255, 255, 255, .3);
      padding: 12px 24px;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 600;
      text-decoration: none;
      transition: all .2s;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      white-space: nowrap;
    }

    .btn-hero-outline:hover {
      background: rgba(255, 255, 255, .2);
      color: #fff;
    }

    .hero-stats {
      display: flex;
      gap: 24px;
      flex-wrap: wrap;
    }

    .hero-stat-item {
      text-align: left;
    }

    .hero-stat-num {
      font-size: 26px;
      font-weight: 800;
      color: #fff;
    }

    .hero-stat-lbl {
      font-size: 12px;
      color: rgba(255, 255, 255, .6);
      margin-top: 2px;
    }

    /* Hero Card Preview */
    .hero-card {
      background: rgba(255, 255, 255, .08);
      border: 1px solid rgba(255, 255, 255, .15);
      border-radius: 16px;
      padding: 20px;
      backdrop-filter: blur(10px);
    }

    .hero-card-title {
      color: #fff;
      font-size: 14px;
      font-weight: 700;
      margin-bottom: 14px;
    }

    .progress-item {
      margin-bottom: 12px;
    }

    .progress-label {
      display: flex;
      justify-content: space-between;
      color: rgba(255, 255, 255, .8);
      font-size: 12px;
      font-weight: 500;
      margin-bottom: 5px;
    }

    .progress-bar-track {
      height: 6px;
      background: rgba(255, 255, 255, .15);
      border-radius: 99px;
      overflow: hidden;
    }

    .progress-bar-fill {
      height: 100%;
      border-radius: 99px;
    }

    /* ── SECTION UMUM ── */
    .section {
      padding: 64px 0;
    }

    .section-alt {
      background: var(--bg);
    }

    .section-label {
      display: inline-block;
      background: var(--accent-soft);
      color: var(--accent);
      font-size: 12px;
      font-weight: 700;
      padding: 4px 12px;
      border-radius: 20px;
      margin-bottom: 12px;
      letter-spacing: .5px;
      text-transform: uppercase;
    }

    .section-title {
      font-size: 28px;
      font-weight: 800;
      color: var(--primary);
      margin-bottom: 12px;
    }

    .section-sub {
      font-size: 15px;
      color: var(--muted);
      line-height: 1.7;
    }

    /* ── FITUR CARDS ── */
    .feature-card {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 24px;
      transition: all .2s;
      height: 100%;
      cursor: pointer;
    }

    .feature-card:hover {
      box-shadow: 0 8px 32px rgba(0, 0, 0, .08);
      transform: translateY(-3px);
    }

    .feature-icon {
      width: 48px;
      height: 48px;
      border-radius: 13px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      margin-bottom: 14px;
    }

    .feature-title {
      font-size: 15px;
      font-weight: 700;
      color: var(--primary);
      margin-bottom: 8px;
    }

    .feature-desc {
      font-size: 13px;
      color: var(--muted);
      line-height: 1.6;
    }

    /* ── PAKET HARGA ── */
    .paket-card {
      background: #fff;
      border: 1.5px solid var(--border);
      border-radius: 16px;
      padding: 28px;
      transition: all .2s;
      height: 100%;
      position: relative;
    }

    .paket-card.featured {
      border-color: var(--primary);
      background: var(--primary);
    }

    .paket-badge {
      position: absolute;
      top: -12px;
      left: 50%;
      transform: translateX(-50%);
      background: var(--accent);
      color: var(--primary);
      font-size: 11px;
      font-weight: 700;
      padding: 3px 14px;
      border-radius: 20px;
      white-space: nowrap;
    }

    .paket-name {
      font-size: 14px;
      font-weight: 700;
      margin-bottom: 4px;
    }

    .paket-price {
      font-size: 30px;
      font-weight: 800;
      margin: 12px 0 4px;
    }

    .paket-period {
      font-size: 12px;
      margin-bottom: 20px;
    }

    .paket-list {
      list-style: none;
      margin-bottom: 24px;
    }

    .paket-list li {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      padding: 5px 0;
    }

    .paket-list li i {
      font-size: 14px;
      flex-shrink: 0;
    }

    .btn-paket {
      width: 100%;
      padding: 11px;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 700;
      cursor: pointer;
      transition: all .2s;
      text-decoration: none;
      display: block;
      text-align: center;
      border: none;
    }

    /* ── TESTIMONI ── */
    .testi-card {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 24px;
      height: 100%;
    }

    .testi-stars {
      color: var(--accent);
      font-size: 14px;
      margin-bottom: 10px;
    }

    .testi-text {
      font-size: 13.5px;
      color: var(--text);
      line-height: 1.7;
      margin-bottom: 16px;
      font-style: italic;
    }

    .testi-user {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .testi-ava {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 13px;
      flex-shrink: 0;
    }

    .testi-name {
      font-size: 13px;
      font-weight: 700;
    }

    .testi-role {
      font-size: 11px;
      color: var(--muted);
    }

    /* ── CTA ── */
    .cta-section {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
      padding: 64px 0;
      text-align: center;
    }

    .cta-title {
      color: #fff;
      font-size: 28px;
      font-weight: 800;
      margin-bottom: 12px;
    }

    .cta-sub {
      color: rgba(255, 255, 255, .7);
      font-size: 15px;
      margin-bottom: 28px;
    }

    /* ── FOOTER ── */
    .footer {
      background: var(--primary);
      padding: 48px 0 24px;
    }

    .footer-brand {
      color: #fff;
      font-size: 18px;
      font-weight: 800;
      margin-bottom: 8px;
    }

    .footer-desc {
      color: rgba(255, 255, 255, .5);
      font-size: 13px;
      line-height: 1.7;
    }

    .footer-title {
      color: #fff;
      font-size: 13px;
      font-weight: 700;
      margin-bottom: 14px;
      text-transform: uppercase;
      letter-spacing: .6px;
    }

    .footer-link {
      display: block;
      color: rgba(255, 255, 255, .5);
      font-size: 13px;
      text-decoration: none;
      margin-bottom: 8px;
      transition: color .2s;
    }

    .footer-link:hover {
      color: #fff;
    }

    .footer-divider {
      border-color: rgba(255, 255, 255, .1);
      margin: 32px 0 20px;
    }

    .footer-copy {
      color: rgba(255, 255, 255, .35);
      font-size: 12px;
      text-align: center;
    }

    /* ── RESPONSIVE BREAKPOINTS ── */

    /* Tablet: md (768px) */
    @media (max-width: 991.98px) {

      /* Navbar */
      .nav-desktop-links {
        display: none !important;
      }

      .hamburger {
        display: flex;
      }

      /* Hero */
      .hero {
        padding: 48px 0 40px;
      }

      .hero-title {
        font-size: 32px;
      }

      .hero-sub {
        font-size: 14px;
      }

      .hero-stats {
        gap: 20px;
      }

      .hero-stat-num {
        font-size: 22px;
      }

      /* Section titles */
      .section-title {
        font-size: 25px;
      }
    }

    /* Mobile: sm (576px) */
    @media (max-width: 767.98px) {

      /* Hero */
      .hero {
        padding: 36px 0 32px;
      }

      .hero-title {
        font-size: 26px;
      }

      .hero-sub {
        font-size: 13.5px;
        margin-bottom: 20px;
      }

      .hero-btns {
        gap: 10px;
        margin-bottom: 28px;
      }

      .btn-hero-primary,
      .btn-hero-outline {
        padding: 11px 18px;
        font-size: 13.5px;
      }

      .hero-stats {
        gap: 16px;
      }

      .hero-stat-num {
        font-size: 20px;
      }

      .hero-stat-lbl {
        font-size: 11px;
      }

      /* Hero card */
      .hero-card {
        margin-top: 4px;
      }

      /* Sections */
      .section {
        padding: 48px 0;
      }

      .section-title {
        font-size: 22px;
      }

      .section-sub {
        font-size: 14px;
      }

      /* Feature card */
      .feature-card {
        padding: 20px;
      }

      /* Paket */
      .paket-price {
        font-size: 26px;
      }

      /* CTA */
      .cta-section {
        padding: 48px 0;
      }

      .cta-title {
        font-size: 22px;
      }

      .cta-sub {
        font-size: 14px;
      }

      .cta-section .d-flex {
        flex-direction: column;
        align-items: center;
      }

      .cta-section .btn-hero-primary,
      .cta-section .btn-hero-outline {
        width: 100%;
        max-width: 320px;
        justify-content: center;
      }

      /* Footer */
      .footer {
        padding: 36px 0 20px;
      }

      .footer-title {
        margin-top: 8px;
      }
    }

    /* Extra small: xs (<400px) */
    @media (max-width: 399.98px) {
      .hero-title {
        font-size: 22px;
      }

      .hero-badge {
        font-size: 11px;
      }

      .hero-btns {
        flex-direction: column;
      }

      .btn-hero-primary,
      .btn-hero-outline {
        justify-content: center;
      }
    }
  </style>
</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar-custom">
    <div class="container d-flex align-items-center justify-content-between">
      <a href="/" class="navbar-brand-custom">
        <div class="nav-logo">A</div>
        <div class="nav-brand-name">Al Ilmi Center</div>
      </a>

      <!-- Desktop Links -->
      <div class="nav-desktop-links d-flex align-items-center gap-3">
        <a href="#fitur" class="nav-link-custom">Fitur</a>
        <a href="#harga" class="nav-link-custom">Harga</a>
        <a href="#testimoni" class="nav-link-custom">Testimoni</a>
        <a href="/login" class="btn-nav-login">Masuk</a>
        <a href="/register" class="btn-nav-daftar">Daftar Gratis</a>
      </div>

      <!-- Hamburger -->
      <button class="hamburger" id="hamburgerBtn" aria-label="Menu">
        <span></span><span></span><span></span>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
      <a href="#fitur" class="nav-link-custom">Fitur</a>
      <a href="#harga" class="nav-link-custom">Harga</a>
      <a href="#testimoni" class="nav-link-custom">Testimoni</a>
      <div class="d-flex gap-2 mt-2">
        <a href="/login" class="btn-nav-login flex-fill text-center">Masuk</a>
        <a href="/register" class="btn-nav-daftar flex-fill text-center">Daftar Gratis</a>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <section class="hero">
    <div class="container">
      <div class="row align-items-center g-4 g-lg-5">
        <div class="col-lg-6" style="position:relative;z-index:1">
          <div class="hero-badge">
            <i class="bi bi-lightning-charge-fill"></i> Platform Bimbel TKA #1
          </div>
          <div class="hero-title">
            Persiapan <span>TKA</span> Lebih Cerdas & Terarah
          </div>
          <div class="hero-sub">
            Latihan soal terstruktur, bimbingan tutor profesional, dan pantau progres belajarmu — semua dalam satu platform.
          </div>
          <div class="hero-btns">
            <a href="/register" class="btn-hero-primary">
              <i class="bi bi-rocket-takeoff-fill"></i> Mulai Belajar Gratis
            </a>
            <a href="#fitur" class="btn-hero-outline">
              <i class="bi bi-play-circle"></i> Lihat Fitur
            </a>
          </div>
          <div class="hero-stats">
            <div class="hero-stat-item">
              <div class="hero-stat-num">{{ number_format($totalSiswa) }}+</div>
              <div class="hero-stat-lbl">Siswa Aktif</div>
            </div>
            <div class="hero-stat-item">
              <div class="hero-stat-num">{{ $totalTutor }}</div>
              <div class="hero-stat-lbl">Tutor Profesional</div>
            </div>
            <div class="hero-stat-item">
              <div class="hero-stat-num">{{ $kepuasan }}%</div>
              <div class="hero-stat-lbl">Tingkat Kepuasan</div>
            </div>
          </div>
        </div>

        <div class="col-lg-6" style="position:relative;z-index:1">
          <div class="hero-card">
            <div class="hero-card-title">📊 Progres Belajar Minggu Ini</div>
            <div class="progress-item">
              <div class="progress-label"><span>Matematika</span><span>82%</span></div>
              <div class="progress-bar-track">
                <div class="progress-bar-fill" style="width:82%;background:var(--accent)"></div>
              </div>
            </div>
            <div class="progress-item">
              <div class="progress-label"><span>Fisika</span><span>68%</span></div>
              <div class="progress-bar-track">
                <div class="progress-bar-fill" style="width:68%;background:#34d399"></div>
              </div>
            </div>
            <div class="progress-item">
              <div class="progress-label"><span>Bahasa Indonesia</span><span>75%</span></div>
              <div class="progress-bar-track">
                <div class="progress-bar-fill" style="width:75%;background:#60a5fa"></div>
              </div>
            </div>
            <div class="progress-item">
              <div class="progress-label"><span>Kimia</span><span>55%</span></div>
              <div class="progress-bar-track">
                <div class="progress-bar-fill" style="width:55%;background:#f472b6"></div>
              </div>
            </div>
            <div class="mt-3 pt-3" style="border-top:1px solid rgba(255,255,255,.15);display:flex;justify-content:space-between;align-items:center;">
              <div style="color:rgba(255,255,255,.6);font-size:12px">Rata-rata nilai</div>
              <div style="color:#fff;font-size:14px;font-weight:700">87.5 / 100</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FITUR -->
  <section class="section" id="fitur">
    <div class="container">
      <div class="text-center mb-5">
        <div class="section-label">Fitur Unggulan</div>
        <div class="section-title">Semua yang Kamu Butuhkan</div>
        <div class="section-sub mx-auto">Platform lengkap untuk persiapan TKA dengan fitur-fitur yang dirancang khusus untuk kebutuhan belajarmu</div>
      </div>
      <div class="row g-3 g-md-4">
        <div class="col-6 col-lg-4">
          <div class="feature-card" onclick="window.location='/register'">
            <div class="feature-icon" style="background:#eff6ff;color:var(--primary)">
              <i class="bi bi-journal-text"></i>
            </div>
            <div class="feature-title">Latihan Soal TKA</div>
            <div class="feature-desc">Ribuan soal terstruktur berdasarkan kemampuan hafalan, perhitungan, dan penalaran untuk SD, SMP, dan SMA.</div>
          </div>
        </div>
        <div class="col-6 col-lg-4">
          <div class="feature-card" onclick="window.location='/register'">
            <div class="feature-icon" style="background:var(--accent-soft);color:#d97706">
              <i class="bi bi-person-video3"></i>
            </div>
            <div class="feature-title">Les Privat Fleksibel</div>
            <div class="feature-desc">Pesan sesi les privat online maupun tatap muka dengan tutor pilihan sesuai jadwal dan kebutuhanmu.</div>
          </div>
        </div>
        <div class="col-6 col-lg-4">
          <div class="feature-card" onclick="window.location='/register'">
            <div class="feature-icon" style="background:var(--success-soft);color:var(--success)">
              <i class="bi bi-graph-up-arrow"></i>
            </div>
            <div class="feature-title">Pantau Progres</div>
            <div class="feature-desc">Lacak perkembangan nilai dan kemampuan belajar secara real-time dengan laporan yang mudah dipahami.</div>
          </div>
        </div>
        <div class="col-6 col-lg-4">
          <div class="feature-card" onclick="window.location='/register'">
            <div class="feature-icon" style="background:#f5f3ff;color:#6d28d9">
              <i class="bi bi-trophy"></i>
            </div>
            <div class="feature-title">Kuis & Evaluasi</div>
            <div class="feature-desc">Uji kemampuan dengan kuis evaluasi dan dapatkan pembahasan soal yang lengkap.</div>
          </div>
        </div>
        <div class="col-6 col-lg-4">
          <div class="feature-card" onclick="window.location='/register'">
            <div class="feature-icon" style="background:#fef2f2;color:#dc2626">
              <i class="bi bi-book-fill"></i>
            </div>
            <div class="feature-title">Materi Lengkap</div>
            <div class="feature-desc">Akses materi pembelajaran ringkas yang disusun oleh tutor berpengalaman sesuai kurikulum TKA.</div>
          </div>
        </div>
        <div class="col-6 col-lg-4">
          <div class="feature-card" onclick="window.location='/register'">
            <div class="feature-icon" style="background:#e0f2fe;color:#0284c7">
              <i class="bi bi-shield-check"></i>
            </div>
            <div class="feature-title">Pembayaran Aman</div>
            <div class="feature-desc">Transaksi pembayaran layanan yang aman dan terpercaya dengan berbagai metode pembayaran tersedia.</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- HARGA -->
  <section class="section section-alt" id="harga">
    <div class="container">
      <div class="text-center mb-5">
        <div class="section-label">Paket Harga</div>
        <div class="section-title">Pilih Paket yang Tepat</div>
        <div class="section-sub mx-auto">Paket belajar yang terjangkau dan sesuai kebutuhan akademikmu</div>
      </div>
      <div class="row g-4 justify-content-center">
        @foreach($pakets as $i => $paket)
        @php
        $isFeatured = $i === 1; // kartu tengah = featured
        $fitur = array_filter([
        $paket->akses_penuh ? 'Akses Materi TKA Penuh' : 'Akses Materi TKA',
        $paket->jumlah_soal !== null ? ($paket->jumlah_soal == 0 ? 'Soal Latihan Tak Terbatas' : $paket->jumlah_soal . ' Soal Latihan/hari') : null,
        $paket->jumlah_les ? $paket->jumlah_les . 'x Les Privat Online' : null,
        $paket->feedback_tutor ? 'Feedback Tutor Langsung' : null,
        ]);
        @endphp
        <div class="col-12 col-md-6 col-lg-4">
          <div class="paket-card {{ $isFeatured ? 'featured' : '' }}">
            @if($isFeatured)
            <div class="paket-badge">⭐ Terpopuler</div>
            @endif
            <div class="paket-name" style="{{ $isFeatured ? 'color:rgba(255,255,255,.7)' : 'color:var(--muted)' }}">
              {{ $paket->nama }}
            </div>
            <div class="paket-price" style="{{ $isFeatured ? 'color:#fff' : 'color:var(--primary)' }}">
              Rp {{ number_format($paket->harga_min / 1000, 0, ',', '.') }}K
            </div>
            <div class="paket-period" style="{{ $isFeatured ? 'color:rgba(255,255,255,.5)' : 'color:var(--muted)' }}">
              per bulan
            </div>
            <ul class="paket-list">
              @foreach($fitur as $f)
              <li {{ $isFeatured ? 'style=color:#fff' : '' }}>
                <i class="bi bi-check-circle-fill" style="color:{{ $isFeatured ? 'var(--accent)' : 'var(--success)' }}"></i>
                {{ $f }}
              </li>
              @endforeach
              @if(!$paket->feedback_tutor)
              <li>
                <i class="bi bi-x-circle-fill" style="color:#cbd5e1"></i> Feedback Tutor
              </li>
              @endif
            </ul>
            <a href="/register" class="btn-paket" style="
          {{ $isFeatured
            ? 'background:var(--accent);color:var(--primary)'
            : ($i === 0
                ? 'background:var(--bg);color:var(--primary);border:1.5px solid var(--border)'
                : 'background:var(--primary);color:#fff')
          }}">
              Pilih Paket
            </a>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- TESTIMONI -->
  <section class="section" id="testimoni">
    <div class="container">
      <div class="text-center mb-5">
        <div class="section-label">Testimoni</div>
        <div class="section-title">Kata Mereka tentang Al Ilmi</div>
        <div class="section-sub mx-auto">Ribuan siswa telah merasakan manfaat belajar bersama Al Ilmi Center</div>
      </div>
      <div class="row g-4">
        @forelse($testimoni as $t)
        @php
        $initials = collect(explode(' ', $t->siswa->name ?? 'U'))
        ->map(fn($w) => strtoupper($w[0]))
        ->take(2)->implode('');
        $bintang = $t->bintang ?? 5;
        $colors = [
        ['bg'=>'#dbeafe','color'=>'#1d4ed8'],
        ['bg'=>'#dcfce7','color'=>'#15803d'],
        ['bg'=>'#fef9c3','color'=>'#b45309'],
        ];
        $c = $colors[$loop->index % 3];
        @endphp
        <div class="col-12 col-md-4">
          <div class="testi-card">
            <div class="testi-stars">
              @for($s = 1; $s <= 5; $s++){{ $s <= $bintang ? '★' : '☆' }}@endfor
                </div>
                <div class="testi-text">"{{ $t->komentar }}"</div>
                <div class="testi-user">
                  <div class="testi-ava" style="background:{{ $c['bg'] }};color:{{ $c['color'] }}">
                    {{ $initials }}
                  </div>
                  <div>
                    <div class="testi-name">{{ $t->siswa->name ?? 'Anonim' }}</div>
                    <div class="testi-role">
                      {{ $t->siswa->jenjang ? 'Siswa ' . strtoupper($t->siswa->jenjang) : 'Siswa' }}
                      @if($t->lesPrivat?->mata_pelajaran) · {{ $t->lesPrivat->mata_pelajaran }} @endif
                    </div>
                  </div>
                </div>
            </div>
          </div>
          @empty
          {{-- Fallback jika belum ada ulasan di DB --}}
          <div class="col-12 text-center text-muted" style="font-size:14px;padding:32px 0">
            Belum ada testimoni tersedia.
          </div>
          @endforelse
        </div>
      </div>
  </section>

  <!-- CTA -->
  <section class="cta-section">
    <div class="container">
      <div class="cta-title">Siap Mulai Belajar? 🚀</div>
      <div class="cta-sub">Bergabung dengan ribuan siswa yang sudah mempersiapkan TKA bersama Al Ilmi Center</div>
      <div class="d-flex gap-3 justify-content-center flex-wrap">
        <a href="/register" class="btn-hero-primary">
          <i class="bi bi-rocket-takeoff-fill"></i> Daftar Sekarang Gratis
        </a>
        <a href="/login" class="btn-hero-outline">
          <i class="bi bi-box-arrow-in-right"></i> Sudah Punya Akun
        </a>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="container">
      <div class="row g-4">
        <div class="col-12 col-lg-4">
          <div class="footer-brand">Al Ilmi Center</div>
          <div class="footer-desc">Platform bimbingan belajar berbasis web untuk persiapan Tes Kemampuan Akademik (TKA) yang fleksibel dan terarah.</div>
        </div>
        <div class="col-6 col-lg-2">
          <div class="footer-title">Menu</div>
          <a href="#fitur" class="footer-link">Fitur</a>
          <a href="#harga" class="footer-link">Harga</a>
          <a href="#testimoni" class="footer-link">Testimoni</a>
        </div>
        <div class="col-6 col-lg-2">
          <div class="footer-title">Akun</div>
          <a href="/login" class="footer-link">Masuk</a>
          <a href="/register" class="footer-link">Daftar</a>
        </div>
        <div class="col-12 col-lg-4">
          <div class="footer-title">Kontak</div>
          <a href="#" class="footer-link"><i class="bi bi-envelope me-2"></i>alilmi@email.com</a>
          <a href="#" class="footer-link"><i class="bi bi-telephone me-2"></i>08xx-xxxx-xxxx</a>
          <a href="#" class="footer-link"><i class="bi bi-geo-alt me-2"></i>Kediri, Jawa Timur</a>
        </div>
      </div>
      <hr class="footer-divider" />
      <div class="footer-copy">© 2025 Al Ilmi Center. Universitas Nusantara PGRI Kediri.</div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Hamburger menu toggle
    const btn = document.getElementById('hamburgerBtn');
    const menu = document.getElementById('mobileMenu');

    btn.addEventListener('click', () => {
      btn.classList.toggle('open');
      menu.classList.toggle('open');
    });

    // Close menu when a link is clicked
    menu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        btn.classList.remove('open');
        menu.classList.remove('open');
      });
    });
  </script>
</body>

</html>