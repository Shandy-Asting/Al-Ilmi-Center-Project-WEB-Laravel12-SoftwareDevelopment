<div>
    @if($sukses)
        <div style="background:#dcfce7;color:#16a34a;padding:12px 16px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:16px;">
            ✅ Jadwal les berhasil dipesan! Menunggu konfirmasi tutor.
        </div>
    @endif

    <div style="font-size:18px;font-weight:800;margin-bottom:20px;">📋 Pesan Jadwal Les Baru</div>

    <form wire:submit.prevent="pesan">
        <div class="row g-3">
            <div class="col-md-6">
                <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Pilih Tutor</label>
                <select wire:model="tutor_id" style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;">
                    <option value="">-- Pilih Tutor --</option>
                    @foreach($tutors as $tutor)
                        <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                    @endforeach
                </select>
                @error('tutor_id') <span style="color:red;font-size:12px;">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6">
                <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Mata Pelajaran</label>
                <select wire:model="mata_pelajaran" style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;">
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    <option value="Matematika">Matematika</option>
                    <option value="Fisika">Fisika</option>
                    <option value="Kimia">Kimia</option>
                    <option value="Biologi">Biologi</option>
                    <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                </select>
                @error('mata_pelajaran') <span style="color:red;font-size:12px;">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6">
                <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Jadwal</label>
                <input type="datetime-local" wire:model="jadwal" style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;"/>
                @error('jadwal') <span style="color:red;font-size:12px;">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6">
                <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Mode Belajar</label>
                <select wire:model="mode" style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;">
                    <option value="">-- Pilih Mode --</option>
                    <option value="online">Online (Zoom)</option>
                    <option value="tatap_muka">Tatap Muka</option>
                </select>
                @error('mode') <span style="color:red;font-size:12px;">{{ $message }}</span> @enderror
            </div>

            <div class="col-12">
                <button type="submit" style="width:100%;padding:12px;border:none;border-radius:10px;background:#1e3a5f;color:#fff;font-size:14px;font-weight:700;cursor:pointer;">
                    <i class="bi bi-send-fill me-2"></i> Kirim Pesanan ke Tutor
                </button>
            </div>
        </div>
    </form>
</div>