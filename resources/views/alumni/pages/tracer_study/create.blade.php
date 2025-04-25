@extends('alumni.layouts.app')
@section('title', 'Form Tracer Study - Step 1')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Form Tracer Study - Step 1</h1>

    <form method="POST" action="{{ route('alumni.tracer_study.storeStep1') }}">
        @csrf

        <div class="card">
            <div class="card-header">
                Step 1 - Verifikasi Data
            </div>
            <div class="card-body">
                <!-- Display data from Alumni model -->
                <div class="form-group">
                    <label for="nis">NIS</label>
                    <input type="text" name="nis" id="nis" class="form-control" value="{{ old('nis', $alumni->nis) }}" readonly>
                </div>
                <div class="form-group">
                    <label for="nisn">NISN</label>
                    <input type="text" name="nisn" id="nisn" class="form-control" value="{{ old('nisn', $alumni->nisn) }}" readonly>
                </div>
                <div class="form-group">
                    <label for="nama_siswa">Nama Siswa</label>
                    <input type="text" name="nama_siswa" id="nama_siswa" class="form-control" value="{{ old('nama_siswa', $alumni->nama) }}" readonly>
                </div>
                <div class="form-group">
                    <label for="jurusan">Jurusan</label>
                    <input type="text" name="jurusan" id="jurusan" class="form-control" value="{{ old('jurusan', $alumni->jurusan->nama_jurusan) }}" readonly>
                </div>
                <div class="form-group">
                    <label for="tahun_lulus">Tahun Lulus</label>
                    <input type="text" name="tahun_lulus" id="tahun_lulus" class="form-control" value="{{ old('tahun_lulus', $alumni->tahun_lulus) }}" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $tracerStudy->email ?? '') }}">
                </div>
                <div class="form-group">
                    <label for="nomor_wa">Nomor WhatsApp</label>
                    <input type="text" name="nomor_wa" id="nomor_wa" class="form-control" value="{{ old('nomor_wa', $tracerStudy->nomor_wa ?? '') }}">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan & Lanjutkan</button>
    </form>
</div>
<div>
@endsection
