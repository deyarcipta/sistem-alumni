@extends('admin.layouts.app')
@section('title', 'Data Tracer Study')

@section('content')
@php
    function konversiSkor($nilai) {
        return match ((int)$nilai) {
            1 => 'Sangat Baik',
            2 => 'Baik',
            3 => 'Cukup',
            4 => 'Kurang',
            5 => 'Tidak Sama Sekali',
            default => '-',
        };
    }

    function konversiSkorTwo($nilai) {
        return match ((int)$nilai) {
            1 => 'Sangat Rendah',
            2 => 'Rendah',
            3 => 'Sangat Tinggi',
            default => '-',
        };
    }
@endphp

<div class="container">
    <h3 class="mb-4">Data Tracer Study Alumni</h3>

    {{-- === TABEL SUDAH MENGISI TRACER STUDY === --}}
    <div class="card mb-4">
        <div class="card-header bg-success text-white d-flex justify-content-between">
            <h5 class="mb-0">Alumni yang Sudah Mengisi Tracer Study</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered" id="sudahTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Alumni</th>
                        <th>Tahun Lulus</th>
                        <th>Status</th>
                        <th>Tempat Kerja / Kuliah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tracerStudies as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->alumni->nama ?? '-' }}</td>
                        <td>{{ $item->alumni->tahun_lulus ?? '-' }}</td>
                        <td>{{ $item->pekerjaan ?? '-' }}</td>
                        <td>{{ $item->perusahaan ?? '-' }}</td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalLihat{{ $item->id }}">👁</button>
                            <form action="{{ route('admin.tracer_study.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">🗑</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Modal Detail --}}
                      <div class="modal fade" id="modalLihat{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title">Detail Tracer Study - {{ $item->nama_siswa }}</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    {{-- Step 1 - Verifikasi Data --}}
                                    <h6 class="mt-2">1. Verifikasi Data</h6>
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item"><strong>NIS:</strong> {{ $item->nis }}</li>
                                        <li class="list-group-item"><strong>NISN:</strong> {{ $item->nisn }}</li>
                                        <li class="list-group-item"><strong>Nama Siswa:</strong> {{ $item->nama_siswa }}</li>
                                        <li class="list-group-item"><strong>Jurusan:</strong> {{ $item->jurusan }}</li>
                                        <li class="list-group-item"><strong>Tahun Lulus:</strong> {{ $item->tahun_lulus }}</li>
                                        <li class="list-group-item"><strong>Nama Lengkap:</strong> {{ $item->nama_lengkap }}</li>
                                        <li class="list-group-item"><strong>Email:</strong> {{ $item->email }}</li>
                                        <li class="list-group-item"><strong>Nomor WA:</strong> {{ $item->nomor_wa }}</li>
                                    </ul>

                                    {{-- Step 2 - Kuisioner Sekolah --}}
                                    <h6 class="mt-4">2. Kuisioner Sekolah</h6>
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item"><strong>Pembelajaran:</strong> {{ $item->pembelajaran }} - {{ konversiSkor($item->pembelajaran) }}</li>
                                        <li class="list-group-item"><strong>Praktek:</strong> {{ $item->praktek }} - {{ konversiSkor($item->praktek) }}</li>
                                        <li class="list-group-item"><strong>Sarana & Prasarana:</strong> {{ $item->sarpras }} - {{ konversiSkor($item->sarpras) }}</li>
                                        <li class="list-group-item"><strong>PKL:</strong> {{ $item->pkl }} - {{ konversiSkor($item->pkl) }}</li>
                                        <li class="list-group-item"><strong>Biaya:</strong> {{ $item->biaya }} - {{ konversiSkor($item->biaya) }}</li>
                                    </ul>

                                    {{-- Step 3 - Kuisioner Dunia Kerja --}}
                                    <h6 class="mt-4">3. Kuisioner Dunia Kerja</h6>
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item"><strong>Mencari Pekerjaan:</strong> {{ $item->mencari_pekerjaan }}</li>
                                        <li class="list-group-item"><strong>Proses Mencari Kerja:</strong> {{ $item->proses_mencari_kerja }}</li>
                                        <li class="list-group-item"><strong>Jumlah Perusahaan Dilamar:</strong> {{ $item->jml_perusahaan }}</li>
                                        <li class="list-group-item"><strong>Respon Perusahaan:</strong> {{ $item->respon_perusahaan }}</li>
                                        <li class="list-group-item"><strong>Undangan Perusahaan:</strong> {{ $item->undangan_perusahaan }}</li>
                                        <li class="list-group-item"><strong>Status Kerja:</strong> {{ $item->status_kerja }}</li>
                                    </ul>

                                    {{-- Step 4 - Data Diri --}}
                                    <h6 class="mt-4">4. Data Diri</h6>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><strong>Apakah Sudah Bekerja Sebelum Lulus:</strong> {{ $item->status_pekerjaan_sebelum_lulus }}</li>
                                        <li class="list-group-item"><strong>Durasi Mendapat Pekerjaan:</strong> {{ $item->durasi_pekerjaan }} Bulan</li>
                                        <li class="list-group-item"><strong>Pekerjaan:</strong> {{ $item->pekerjaan }}</li>
                                        <li class="list-group-item"><strong>Perusahaan:</strong> {{ $item->perusahaan }}</li>
                                        <li class="list-group-item"><strong>Posisi:</strong> {{ $item->posisi_pekerjaan }}</li>
                                        <li class="list-group-item"><strong>Tahun Masuk:</strong> {{ $item->tahun_masuk_pekerjaan }}</li>
                                        <li class="list-group-item"><strong>Gaji:</strong> {{$item->gaji}}</li>
                                        <li class="list-group-item"><strong>Etika:</strong> {{$item->etika}} - {{ konversiSkorTwo($item->etika) }}</li>
                                        <li class="list-group-item"><strong>Bahasa Inggris:</strong> {{$item->bahasa_inggris}} - {{ konversiSkorTwo($item->bahasa_inggris) }}</li>
                                        <li class="list-group-item"><strong>Komunikasi:</strong> {{$item->komunikasi}} - {{ konversiSkorTwo($item->komunikasi) }}</li>
                                        <li class="list-group-item"><strong>Kerja Sama:</strong> {{$item->kerja_sama}} - {{ konversiSkorTwo($item->kerja_sama) }}</li>
                                        <li class="list-group-item"><strong>Pengembangan Diri:</strong> {{$item->pengembangan_diri}} - {{ konversiSkorTwo($item->pengembangan_diri) }}<li>
                                        <li class="list-group-item"><strong>Saran:</strong> {{ $item->saran }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                      </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal Detail -->
    {{-- <div class="modal fade" id="modalLihat{{ $item->nis }}" tabindex="-1">
      <div class="modal-dialog modal-xl">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Detail Tracer Study</h5>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">

                  {{-- Step 1 - Verifikasi Data --}}
                  {{-- <h6 class="mb-2">1. Verifikasi Data</h6>
                  <table class="table table-bordered">
                      <tr><th>NIS</th><td>{{ $item->nis }}</td></tr>
                      <tr><th>NISN</th><td>{{ $item->nisn }}</td></tr>
                      <tr><th>Nama Siswa</th><td>{{ $item->nama_siswa }}</td></tr>
                      <tr><th>Jurusan</th><td>{{ $item->jurusan }}</td></tr>
                      <tr><th>Tahun Lulus</th><td>{{ $item->tahun_lulus }}</td></tr>
                      <tr><th>Nama Lengkap</th><td>{{ $item->nama_lengkap }}</td></tr>
                      <tr><th>Email</th><td>{{ $item->email }}</td></tr>
                      <tr><th>Nomor WA</th><td>{{ $item->nomor_wa }}</td></tr>
                      <tr><th>NIK</th><td>{{ $item->nik }}</td></tr>
                      <tr><th>NPWP</th><td>{{ $item->npwp }}</td></tr>
                  </table> --}}

                  {{-- Step 2 - Kuisioner Sekolah --}}
                  {{-- <h6 class="mt-4 mb-2">2. Kuisioner Sekolah</h6>
                  <table class="table table-bordered">
                      <tr><th>Pembelajaran</th><td>{{ $item->pembelajaran }}</td></tr>
                      <tr><th>Praktek</th><td>{{ $item->praktek }}</td></tr>
                      <tr><th>Sarana & Prasarana</th><td>{{ $item->sarpras }}</td></tr>
                      <tr><th>PKL</th><td>{{ $item->pkl }}</td></tr>
                      <tr><th>Biaya</th><td>{{ $item->biaya }}</td></tr>
                  </table> --}}

                  {{-- Step 3 - Kuisioner Dunia Kerja --}}
                  {{-- <h6 class="mt-4 mb-2">3. Kuisioner Dunia Kerja</h6>
                  <table class="table table-bordered">
                      <tr><th>Mencari Pekerjaan</th><td>{{ $item->mencari_pekerjaan }}</td></tr>
                      <tr><th>Proses Mencari Kerja</th><td>{{ $item->proses_mencari_kerja }}</td></tr>
                      <tr><th>Jumlah Perusahaan Dilamar</th><td>{{ $item->jml_perusahaan }}</td></tr>
                      <tr><th>Respon Perusahaan</th><td>{{ $item->respon_perusahaan }}</td></tr>
                      <tr><th>Undangan Perusahaan</th><td>{{ $item->undangan_perusahaan }}</td></tr>
                      <tr><th>Status Kerja</th><td>{{ $item->status_kerja }}</td></tr>
                  </table> --}}

                  {{-- Step 4 - Data Diri --}}
                  {{-- <h6 class="mt-4 mb-2">4. Data Diri</h6>
                  <table class="table table-bordered">
                      <tr><th>Status Sebelum Lulus</th><td>{{ $item->status_pekerjaan_sebelum_lulus }}</td></tr>
                      <tr><th>Durasi Mendapatkan Pekerjaan</th><td>{{ $item->durasi_pekerjaan }}</td></tr>
                      <tr><th>Pekerjaan</th><td>{{ $item->pekerjaan }}</td></tr>
                      <tr><th>Nama Perusahaan</th><td>{{ $item->perusahaan }}</td></tr>
                      <tr><th>Posisi</th><td>{{ $item->posisi_pekerjaan }}</td></tr>
                      <tr><th>Tahun Masuk</th><td>{{ $item->tahun_masuk_pekerjaan }}</td></tr>
                      <tr><th>Gaji</th><td>{{ $item->gaji }}</td></tr>
                      <tr><th>Etika</th><td>{{ $item->etika }}</td></tr>
                      <tr><th>Bahasa Inggris</th><td>{{ $item->bahasa_inggris }}</td></tr>
                      <tr><th>Komunikasi</th><td>{{ $item->komunikasi }}</td></tr>
                      <tr><th>Kerja Sama</th><td>{{ $item->kerja_sama }}</td></tr>
                      <tr><th>Pengembangan Diri</th><td>{{ $item->pengembangan_diri }}</td></tr>
                      <tr><th>Saran</th><td>{{ $item->saran }}</td></tr>
                  </table>
              </div>
          </div>
      </div>
    </div>  --}}

    {{-- === TABEL BELUM MENGISI TRACER STUDY === --}}
    <div class="card">
        <div class="card-header bg-warning d-flex justify-content-between">
            <h5 class="mb-0">Alumni yang Belum Mengisi Tracer Study</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered" id="belumTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Alumni</th>
                        <th>Tahun Lulus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alumniTanpaTracer as $index => $alumni)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $alumni->nama }}</td>
                        <td>{{ $alumni->tahun_lulus }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables -->
<script>
    $(document).ready(function () {
        $('#sudahTable, #belumTable').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Tidak ditemukan data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                infoFiltered: "(difilter dari _MAX_ total data)"
            }
        });
    });

    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 3000,            
            showConfirmButton: false
        });
    @endif
</script>
@endpush
