@extends('alumni.layouts.app')
@section('title', 'Form Tracer Study - Step 3')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Form Tracer Study - Step 3</h1>

    <form method="POST" action="{{ route('alumni.tracer_study.storeStep3', ['id' => $tracerStudy->id]) }}">
        @csrf

        <div class="card">
            <div class="card-header">
                Step 3 - Kuisioner Dunia Kerja
            </div>
            <div class="card-body">

                <div class="form-group">
                    <label for="mencari_pekerjaan">Apakah Anda mencari pekerjaan sebelum lulus?</label>
                    <select name="mencari_pekerjaan" id="mencari_pekerjaan" class="form-control">
                        <option value="" {{ old('mencari_pekerjaan', $tracerStudy->mencari_pekerjaan) === null ? 'selected' : '' }}>-</option>
                        <option value="Iya" {{ old('mencari_pekerjaan', $tracerStudy->mencari_pekerjaan) === 'Iya' ? 'selected' : '' }}>Iya</option>
                        <option value="Tidak" {{ old('mencari_pekerjaan', $tracerStudy->mencari_pekerjaan) === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="proses_mencari_kerja">Bagaimana proses mencari kerja Anda?</label>
                    <select name="proses_mencari_kerja" id="proses_mencari_kerja" class="form-control">
                        @php
                            $options = [
                                'Melalui iklan di koran/majalah, brosur',
                                'Melamar ke perusahaan tanpa mengetahui lowongan yang ada',
                                'Pergi ke bursa/pameran kerja',
                                'Mencari lewat internet/iklan online/milis',
                                'Dihubungi oleh perusahaan',
                                'Menghubungi Kemenakertrans',
                                'Menghubungi agen tenaga kerja komersial/swasta',
                                'Memeroleh informasi dari pusat/kantor pengembangan karir fakultas/universitas',
                                'Menghubungi kantor kemahasiswaan/hubungan alumni',
                                'Membangun jejaring (network) sejak masih kuliah',
                                'Melalui relasi (misalnya dosen, orang tua, saudara, teman, dll.)',
                                'Membangun bisnis sendiri',
                                'Melalui penempatan kerja atau magang',
                                'Bekerja di tempat yang sama dengan tempat kerja semasa kuliah'
                            ];
                        @endphp
                        <option value="">-- Pilih Proses --</option>
                        @foreach($options as $option)
                            <option value="{{ $option }}" {{ old('proses_mencari_kerja', $tracerStudy->proses_mencari_kerja) === $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="jml_perusahaan">Berapa perusahaan yang Anda lamar?</label>
                    <input type="number" name="jml_perusahaan" id="jml_perusahaan" class="form-control" value="{{ old('jml_perusahaan', $tracerStudy->jml_perusahaan) }}">
                </div>

                <div class="form-group">
                    <label for="respon_perusahaan">Berapa perusahaan yang merespon?</label>
                    <input type="number" name="respon_perusahaan" id="respon_perusahaan" class="form-control" value="{{ old('respon_perusahaan', $tracerStudy->respon_perusahaan) }}">
                </div>

                <div class="form-group">
                    <label for="undangan_perusahaan">Berapa perusahaan yang mengundang Anda?</label>
                    <input type="number" name="undangan_perusahaan" id="undangan_perusahaan" class="form-control" value="{{ old('undangan_perusahaan', $tracerStudy->undangan_perusahaan) }}">
                </div>

                <div class="form-group">
                    <label for="status_kerja">Apa status pekerjaan Anda saat ini?</label>
                    <select name="status_kerja" id="status_kerja" class="form-control">
                        <option value="">-- Pilih Status --</option>
                        <option value="Bekerja" {{ old('status_kerja', $tracerStudy->status_kerja) === 'Bekerja' ? 'selected' : '' }}>Bekerja</option>
                        <option value="Wirausaha" {{ old('status_kerja', $tracerStudy->status_kerja) === 'Wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                        <option value="Tidak bekerja" {{ old('status_kerja', $tracerStudy->status_kerja) === 'Tidak bekerja' ? 'selected' : '' }}>Tidak bekerja</option>
                    </select>
                </div>

            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan & Lanjutkan</button>
    </form>
</div>
@endsection
