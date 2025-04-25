@extends('alumni.layouts.app')
@section('title', 'Form Tracer Study - Step 4')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Form Tracer Study - Step 4</h1>

    <form method="POST" action="{{ route('alumni.tracer_study.storeStep4', ['id' => $tracerStudy->id]) }}">
        @csrf

        <div class="card">
            <div class="card-header">
                Step 4 - Data Diri
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="status_pekerjaan_sebelum_lulus">Apakah Anda sudah bekerja sebelum lulus?</label>
                    <select name="status_pekerjaan_sebelum_lulus" id="status_pekerjaan_sebelum_lulus" class="form-control">
                        <option value="">-</option>
                        <option value="Iya" {{ old('status_pekerjaan_sebelum_lulus', $tracerStudy->status_pekerjaan_sebelum_lulus) == 'Iya' ? 'selected' : '' }}>Iya</option>
                        <option value="Tidak" {{ old('status_pekerjaan_sebelum_lulus', $tracerStudy->status_pekerjaan_sebelum_lulus) === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="durasi_pekerjaan">Durasi bekerja sebelum/sesudah lulus (bulan)</label>
                    <input type="number" name="durasi_pekerjaan" id="durasi_pekerjaan" class="form-control" value="{{ old('durasi_pekerjaan', $tracerStudy->durasi_pekerjaan) }}">
                </div>

                <div class="form-group">
                    <label for="pekerjaan">Pekerjaan saat ini</label>
                    <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="{{ old('pekerjaan', $tracerStudy->pekerjaan) }}">
                </div>

                <div class="form-group">
                    <label for="perusahaan">Perusahaan tempat bekerja</label>
                    <input type="text" name="perusahaan" id="perusahaan" class="form-control" value="{{ old('perusahaan', $tracerStudy->perusahaan) }}">
                </div>

                <div class="form-group">
                    <label for="posisi_pekerjaan">Posisi pekerjaan</label>
                    <input type="text" name="posisi_pekerjaan" id="posisi_pekerjaan" class="form-control" value="{{ old('posisi_pekerjaan', $tracerStudy->posisi_pekerjaan) }}">
                </div>

                <div class="form-group">
                    <label for="tahun_masuk_pekerjaan">Tahun masuk pekerjaan</label>
                    <input type="text" name="tahun_masuk_pekerjaan" id="tahun_masuk_pekerjaan" class="form-control" value="{{ old('tahun_masuk_pekerjaan', $tracerStudy->tahun_masuk_pekerjaan) }}">
                </div>

                <div class="form-group">
                    <label for="gaji">Gaji saat ini</label>
                    <input type="text" name="gaji" id="gaji" class="form-control" value="{{ old('gaji', $tracerStudy->gaji) }}">
                </div>

                <div class="form-group">
                    <label for="etika">Penilaian Etika (0 = Sangat Rendah, 3 = Sangat Tinggi)</label>
                    <select name="etika" id="etika" class="form-control">
                        @for ($i = 0; $i <= 3; $i++)
                            <option value="{{ $i }}" {{ old('etika', $tracerStudy->etika) == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="form-group">
                    <label for="bahasa_inggris">Kemampuan Bahasa Inggris (0 = Sangat Rendah, 3 = Sangat Tinggi)</label>
                    <select name="bahasa_inggris" id="bahasa_inggris" class="form-control">
                        @for ($i = 0; $i <= 3; $i++)
                            <option value="{{ $i }}" {{ old('bahasa_inggris', $tracerStudy->bahasa_inggris) == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="form-group">
                    <label for="komunikasi">Kemampuan Komunikasi (0 = Sangat Rendah, 3 = Sangat Tinggi)</label>
                    <select name="komunikasi" id="komunikasi" class="form-control">
                        @for ($i = 0; $i <= 3; $i++)
                            <option value="{{ $i }}" {{ old('komunikasi', $tracerStudy->komunikasi) == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="form-group">
                    <label for="kerja_sama">Kemampuan Kerja Sama (0 = Sangat Rendah, 3 = Sangat Tinggi)</label>
                    <select name="kerja_sama" id="kerja_sama" class="form-control">
                        @for ($i = 0; $i <= 3; $i++)
                            <option value="{{ $i }}" {{ old('kerja_sama', $tracerStudy->kerja_sama) == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="form-group">
                    <label for="pengembangan_diri">Pengembangan Diri (0 = Sangat Rendah, 3 = Sangat Tinggi)</label>
                    <select name="pengembangan_diri" id="pengembangan_diri" class="form-control">
                        @for ($i = 0; $i <= 3; $i++)
                            <option value="{{ $i }}" {{ old('pengembangan_diri', $tracerStudy->pengembangan_diri) == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="form-group">
                    <label for="saran">Saran dan masukan Anda Untuk Sekolah</label>
                    <textarea name="saran" id="saran" rows="3" class="form-control">{{ old('saran', $tracerStudy->saran) }}</textarea>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Selesaikan</button>
    </form>
</div>

<!-- Modal Selesai Tracer Study -->
<div class="modal fade" id="modalCompleted" tabindex="-1" role="dialog" aria-labelledby="modalCompletedLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-success">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="modalCompletedLabel">Tracer Study Selesai</h5>
      </div>
      <div class="modal-body text-center">
        <p>Terima kasih! Anda telah menyelesaikan seluruh pengisian Tracer Study.</p>
        <p class="text-success font-weight-bold">Sukses untuk karier dan masa depan Anda! 🎓✨</p>
      </div>
      <div class="modal-footer">
        <a href="{{ route('alumni.dashboard.index') }}" class="btn btn-success">Kembali ke Dashboard</a>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
@if (session('completed'))
<script>
    $(document).ready(function() {
        $('#modalCompleted').modal('show');
    });
</script>
@endif
@endpush


