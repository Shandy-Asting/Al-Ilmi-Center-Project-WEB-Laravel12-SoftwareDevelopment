@extends('layouts.app')
@section('title', 'Latihan Soal - Al Ilmi Center')
@section('sidebar-sub', 'Portal Siswa')
@section('page-title', 'Latihan Soal')
@section('page-sub', 'Belajar TKA / Latihan Soal')

@section('sidebar-menu')
    <div class="menu-label">Menu Utama</div>
    <a href="/siswa/dashboard" class="nav-item-custom"><i class="bi bi-grid-fill"></i> Dashboard</a>
    <a href="/siswa/belajar-tka" class="nav-item-custom active"><i class="bi bi-book-fill"></i> Belajar TKA</a>
    <a href="/siswa/les-privat" class="nav-item-custom"><i class="bi bi-person-video3"></i> Les Privat</a>
    <a href="/siswa/hasil-progres" class="nav-item-custom"><i class="bi bi-bar-chart-line-fill"></i> Hasil & Progres</a>
    <div class="menu-label">Akun</div>
    <a href="/siswa/pembayaran" class="nav-item-custom"><i class="bi bi-credit-card-fill"></i> Pembayaran</a>
    <a href="/siswa/profil" class="nav-item-custom"><i class="bi bi-person-circle"></i> Profil Saya</a>
@endsection

@section('content')

<form method="POST" action="/siswa/belajar-tka/{{ $materi->id }}/submit" id="form-latihan">
    @csrf
    <input type="hidden" name="tipe" value="latihan">
    <input type="hidden" name="durasi_menit" id="durasi_menit" value="0">

    {{-- HEADER --}}
    <div style="background:linear-gradient(135deg,#1e3a5f,#2d5282);border-radius:16px;padding:20px 24px;color:#fff;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;">
        <div>
            <div style="font-size:16px;font-weight:800;">{{ $materi->judul }}</div>
            <div style="font-size:12.5px;opacity:.8;">{{ $materi->mata_pelajaran }} · {{ strtoupper($materi->jenjang) }} · {{ count($soal) }} Soal</div>
        </div>
        <div style="background:rgba(255,255,255,.15);border-radius:10px;padding:8px 16px;text-align:center;">
            <div style="font-size:22px;font-weight:800;" id="timer">20:00</div>
            <div style="font-size:10px;opacity:.7;">Sisa Waktu</div>
        </div>
    </div>

    {{-- SOAL --}}
    @forelse($soal as $index => $s)
    <div class="soal-item" id="soal-{{ $index }}" style="{{ $index > 0 ? 'display:none;' : '' }}background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:24px;margin-bottom:16px;">
        <div style="font-size:11px;font-weight:700;color:#1e3a5f;text-transform:uppercase;margin-bottom:10px;">SOAL {{ $index + 1 }} DARI {{ count($soal) }}</div>
        <div style="font-size:15px;line-height:1.7;margin-bottom:20px;font-weight:500;">{{ $s->pertanyaan }}</div>

        @foreach(['a','b','c','d'] as $opsi)
        <label style="display:flex;align-items:flex-start;gap:12px;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:12px;margin-bottom:10px;cursor:pointer;transition:all .2s;" class="opsi-label">
            <input type="radio" name="jawaban[{{ $s->id }}]" value="{{ $opsi }}" style="display:none;" onchange="piliOpsi(this)">
            <div class="opsi-key" style="width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;background:#f1f5f9;color:#64748b;flex-shrink:0;">{{ strtoupper($opsi) }}</div>
            <div style="font-size:13.5px;line-height:1.5;padding-top:4px;">{{ $s->{'pilihan_' . $opsi} }}</div>
        </label>
        @endforeach

        <div style="display:flex;justify-content:space-between;margin-top:20px;">
            @if($index > 0)
            <button type="button" onclick="prevSoal({{ $index }})" style="border:none;border-radius:10px;padding:10px 22px;font-size:13px;font-weight:700;background:#f1f5f9;color:#64748b;cursor:pointer;">
                <i class="bi bi-chevron-left me-1"></i> Sebelumnya
            </button>
            @else
            <div></div>
            @endif

            @if($index < count($soal) - 1)
            <button type="button" onclick="nextSoal({{ $index }})" style="border:none;border-radius:10px;padding:10px 22px;font-size:13px;font-weight:700;background:#1e3a5f;color:#fff;cursor:pointer;">
                Selanjutnya <i class="bi bi-chevron-right ms-1"></i>
            </button>
            @else
            <button type="submit" style="border:none;border-radius:10px;padding:10px 22px;font-size:13px;font-weight:700;background:#16a34a;color:#fff;cursor:pointer;">
                <i class="bi bi-check-circle-fill me-1"></i> Kumpulkan Jawaban
            </button>
            @endif
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:40px;background:#fff;border-radius:16px;">
        <i class="bi bi-inbox" style="font-size:48px;color:#94a3b8;"></i>
        <div style="font-size:15px;font-weight:600;margin-top:12px;">Belum ada soal untuk materi ini</div>
        <a href="/siswa/belajar-tka" style="display:inline-block;margin-top:12px;padding:8px 20px;background:#1e3a5f;color:#fff;border-radius:8px;text-decoration:none;font-size:13px;font-weight:700;">Kembali</a>
    </div>
    @endforelse

</form>

@endsection

@push('scripts')
<script>
    // Timer
    let totalDetik = 20 * 60;
    let startTime = Date.now();
    const timerEl = document.getElementById('timer');
    const durasiEl = document.getElementById('durasi_menit');

    const interval = setInterval(() => {
        if (totalDetik <= 0) {
            clearInterval(interval);
            document.getElementById('form-latihan').submit();
            return;
        }
        totalDetik--;
        const m = Math.floor(totalDetik / 60).toString().padStart(2, '0');
        const s = (totalDetik % 60).toString().padStart(2, '0');
        if (timerEl) timerEl.textContent = m + ':' + s;
    }, 1000);

    document.getElementById('form-latihan').addEventListener('submit', function() {
        const elapsed = Math.round((Date.now() - startTime) / 60000);
        durasiEl.value = elapsed;
        clearInterval(interval);
    });

    function nextSoal(current) {
        document.getElementById('soal-' + current).style.display = 'none';
        document.getElementById('soal-' + (current + 1)).style.display = '';
        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    function prevSoal(current) {
        document.getElementById('soal-' + current).style.display = 'none';
        document.getElementById('soal-' + (current - 1)).style.display = '';
        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    function piliOpsi(input) {
        const label = input.closest('.opsi-label');
        const allLabels = label.closest('.soal-item').querySelectorAll('.opsi-label');
        allLabels.forEach(l => {
            l.style.borderColor = '#e2e8f0';
            l.style.background = '#fff';
            l.querySelector('.opsi-key').style.background = '#f1f5f9';
            l.querySelector('.opsi-key').style.color = '#64748b';
        });
        label.style.borderColor = '#1e3a5f';
        label.style.background = '#eff6ff';
        label.querySelector('.opsi-key').style.background = '#1e3a5f';
        label.querySelector('.opsi-key').style.color = '#fff';
    }
</script>
@endpush