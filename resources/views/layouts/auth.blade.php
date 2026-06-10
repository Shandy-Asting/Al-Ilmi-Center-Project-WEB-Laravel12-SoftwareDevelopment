<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <title>@yield('title', 'Al Ilmi Center')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <style>
        :root {
            --primary: #1e3a5f;
            --primary-light: #2d5282;
            --accent: #f6ad3c;
            --bg: #f1f5f9;
            --card-bg: #ffffff;
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
            position: absolute;
            top: -60px;
            right: -60px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, .05);
            border-radius: 50%;
        }

        .auth-left::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -40px;
            width: 350px;
            height: 350px;
            background: rgba(255, 255, 255, .04);
            border-radius: 50%;
        }

        .auth-left-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .auth-logo {
            width: 64px;
            height: 64px;
            background: var(--accent);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: var(--primary);
            font-weight: 800;
            margin: 0 auto 20px;
        }

        .auth-brand {
            color: #fff;
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .auth-tagline {
            color: rgba(255, 255, 255, .65);
            font-size: 14px;
            max-width: 300px;
            line-height: 1.6;
        }

        .auth-features {
            margin-top: 40px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .auth-feature {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .12);
            padding: 12px 16px;
            border-radius: 12px;
        }

        .auth-feature-icon {
            width: 36px;
            height: 36px;
            background: var(--accent);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 16px;
            flex-shrink: 0;
        }

        .auth-feature-text {
            color: #fff;
            font-size: 13px;
            font-weight: 500;
        }

        .auth-feature-sub {
            color: rgba(255, 255, 255, .5);
            font-size: 11px;
            margin-top: 2px;
        }

        /* ── KANAN (form) ── */
        .auth-right {
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            background: var(--card-bg);
        }

        .auth-box {
            width: 100%;
            max-width: 420px;
        }

        .auth-title {
            font-size: 24px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 6px;
        }

        .auth-sub {
            font-size: 13.5px;
            color: var(--muted);
            margin-bottom: 28px;
        }

        /* Form */
        .form-label-custom {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 6px;
        }

        .form-control-custom {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 13.5px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text);
            background: #fff;
            transition: all .2s;
            outline: none;
        }

        .form-control-custom:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(30, 58, 95, .08);
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 15px;
        }

        .input-wrap .form-control-custom {
            padding-left: 38px;
        }

        .input-toggle {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 15px;
            cursor: pointer;
        }

        .btn-primary-custom {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: var(--primary);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-primary-custom:hover {
            background: var(--primary-light);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
            color: var(--muted);
            font-size: 12px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .auth-link {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .auth-link:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-left {
                display: none;
            }

            .auth-right {
                width: 100%;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- Kiri: Ilustrasi --}}
    <div class="auth-left">
        <div class="auth-left-content">
            <img src="{{ asset('logo.png') }}" alt="Al Ilmi Center"
                style="width:64px;height:64px;object-fit:contain;border-radius:16px;background:#fff;padding:4px;margin:0 auto 20px;display:block;">
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
            {{ $slot ?? '' }}
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

    {{-- Loading Auth --}}
    <div id="global-loading"
        style="display:none;position:fixed;inset:0;z-index:99999;background:rgba(15,23,42,0.55);backdrop-filter:blur(4px);align-items:center;justify-content:center;">
        <div
            style="background:#fff;border-radius:20px;padding:32px 40px;display:flex;flex-direction:column;align-items:center;gap:16px;box-shadow:0 20px 60px rgba(0,0,0,.2);animation:loadingPop .25s ease;">
            <div style="position:relative;width:56px;height:56px;">
                <svg style="position:absolute;inset:0;animation:spinRing 1.2s linear infinite;" viewBox="0 0 56 56"
                    width="56" height="56">
                    <circle cx="28" cy="28" r="24" fill="none" stroke="#e2e8f0" stroke-width="4" />
                    <circle cx="28" cy="28" r="24" fill="none" stroke="#1e3a5f" stroke-width="4"
                        stroke-linecap="round" stroke-dasharray="40 110" transform="rotate(-90 28 28)" />
                </svg>
                <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                    <div
                        style="width:18px;height:18px;background:#1e3a5f;border-radius:50%;animation:pulseDot 1.2s ease-in-out infinite;">
                    </div>
                </div>
            </div>
            <div style="text-align:center;">
                <div id="loading-title"
                    style="font-size:14px;font-weight:700;color:#1e293b;font-family:'Plus Jakarta Sans',sans-serif;">
                    Masuk ke Akun...</div>
                <div style="font-size:12px;color:#64748b;margin-top:4px;font-family:'Plus Jakarta Sans',sans-serif;">
                    Memverifikasi kredensial</div>
            </div>
            <div style="display:flex;gap:6px;">
                <div
                    style="width:7px;height:7px;border-radius:50%;background:#1e3a5f;animation:dotBounce 1.2s ease-in-out infinite;animation-delay:0s;">
                </div>
                <div
                    style="width:7px;height:7px;border-radius:50%;background:#1e3a5f;animation:dotBounce 1.2s ease-in-out infinite;animation-delay:.2s;">
                </div>
                <div
                    style="width:7px;height:7px;border-radius:50%;background:#1e3a5f;animation:dotBounce 1.2s ease-in-out infinite;animation-delay:.4s;">
                </div>
            </div>
        </div>
    </div>
    <div id="loading-bar"
        style="display:none;position:fixed;top:0;left:0;height:3px;background:linear-gradient(90deg,#1e3a5f,#f6ad3c);z-index:100000;border-radius:0 2px 2px 0;width:0%;transition:width .1s ease;box-shadow:0 0 8px rgba(246,173,60,.6);">
    </div>
    <style>
        @keyframes spinRing {
            from {
                transform: rotate(0)
            }

            to {
                transform: rotate(360deg)
            }
        }

        @keyframes pulseDot {

            0%,
            100% {
                transform: scale(1);
                opacity: 1
            }

            50% {
                transform: scale(.6);
                opacity: .5
            }
        }

        @keyframes dotBounce {

            0%,
            80%,
            100% {
                transform: translateY(0);
                opacity: .4
            }

            40% {
                transform: translateY(-6px);
                opacity: 1
            }
        }

        @keyframes loadingPop {
            from {
                transform: scale(.88) translateY(10px);
                opacity: 0
            }

            to {
                transform: scale(1) translateY(0);
                opacity: 1
            }
        }
    </style>
    <script>
        (function() {
            const overlay = document.getElementById('global-loading');
            const bar = document.getElementById('loading-bar');
            let bw = 0,
                bt = null;

            function startBar() {
                bw = 0;
                bar.style.display = 'block';
                bar.style.width = '0%';
                clearInterval(bt);
                bt = setInterval(() => {
                    if (bw < 85) {
                        bw += bw < 30 ? 8 : bw < 60 ? 4 : 1.5;
                        bar.style.width = bw + '%';
                    }
                }, 120);
            }

            function finishBar() {
                clearInterval(bt);
                bar.style.width = '100%';
                setTimeout(() => {
                    bar.style.display = 'none';
                    bar.style.width = '0%';
                    bw = 0;
                }, 350);
            }

            function show() {
                overlay.style.display = 'flex';
                startBar();
            }

            function hide() {
                finishBar();
                setTimeout(() => overlay.style.display = 'none', 300);
            }

            // Skip Livewire form — biarkan Livewire handle sendiri
            document.addEventListener('submit', function(e) {
                const form = e.target;
                if (form.dataset.noloading) return;
                if (form.hasAttribute('wire:submit.prevent') ||
                    form.hasAttribute('wire:submit')) return;
                show();
            }, true);

            window.addEventListener('pageshow', hide);
            window.showLoading = show;
            window.hideLoading = hide;
        })();
    </script>
</body>

</html>
