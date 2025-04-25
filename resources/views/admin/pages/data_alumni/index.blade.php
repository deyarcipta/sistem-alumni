@extends('admin.layouts.app')
@section('title', 'Data Alumni')
@section('content')
<div class="container">
    <h3 class="mb-4">Data Alumni</h3>
    {{-- @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif --}}
    {{-- Dropdown filter tahun lulus --}}
    <form method="GET" action="{{ route('admin.alumni.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <label for="tahun_lulus">Filter Tahun Lulus</label>
                <select name="tahun_lulus" id="tahun_lulus" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Semua Tahun --</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ request('tahun_lulus') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    <div class="card mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4 card-header">
            Data Alumni {{ request('tahun_lulus') ? 'Tahun ' . request('tahun_lulus') : '' }}
            <button class="btn btn-success" data-toggle="modal" data-target="#modalTambahAlumni">Tambah Alumni</button>
            {{-- <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#modalImport">
                <i class="fas fa-file-import"></i> Import Data
            </button> --}}
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped" id="alumniTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Alumni</th>
                        <th>NIS</th>
                        <th>Tahun Lulus</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alumni as $index => $a)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $a->nama }}</td>
                            <td>{{ $a->nis }}</td>
                            <td>{{ $a->tahun_lulus }}</td>
                            <td>
                                <!-- Detail Button -->
                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalDetail{{ $a->id_alumni }}">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <!-- Edit Button -->
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit{{ $a->id_alumni }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('admin.alumni.resetPassword', $a->id_alumni) }}" method="POST" style="display: inline-block;" class="formResetPassword">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-key"></i>
                                    </button>
                                </form>

                                <!-- Hapus Button -->
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapus{{ $a->id_alumni }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Modal Detail dan Edit --}}
            @foreach($alumni as $a)
                {{-- Modal Detail --}}
                <div class="modal fade" id="modalDetail{{ $a->id_alumni }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><strong>Detail Alumni:</strong> {{ $a->nama }}</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <tr><th>Nama</th><td>{{ $a->nama }}</td></tr>
                                    <tr><th>NIS</th><td>{{ $a->nis }}</td></tr>
                                    <tr><th>NISN</th><td>{{ $a->nisn }}</td></tr>
                                    <tr><th>Jurusan</th><td>{{ $a->jurusan->nama_jurusan }}</td></tr>
                                    <tr><th>Tempat, Tanggal Lahir</th><td>{{ $a->tempat_lahir }}, {{ $a->tanggal_lahir }}</td></tr>
                                    <tr><th>Jenis Kelamin</th><td>{{ $a->jenis_kelamin }}</td></tr>
                                    <tr><th>Agama</th><td>{{ $a->agama }}</td></tr>
                                    <tr><th>Alamat</th><td>{{ $a->alamat }}</td></tr>
                                    <tr><th>No HP</th><td>{{ $a->no_hp }}</td></tr>
                                    <tr><th>Email</th><td>{{ $a->email }}</td></tr>
                                    <tr><th>Tahun Lulus</th><td>{{ $a->tahun_lulus }}</td></tr>
                                    <tr><th>Sekolah SD</th><td>{{ $a->sekolah_sd }} ({{ $a->tahun_lulus_sd }})</td></tr>
                                    <tr><th>Sekolah SMP</th><td>{{ $a->sekolah_smp }} ({{ $a->tahun_lulus_smp }})</td></tr>
                                    <tr><th>Sekolah SMK</th><td>{{ $a->sekolah_smk }}</td></tr>
                                    <tr><th>Pengalaman Kerja</th><td>{{ $a->pengalaman_kerja }}</td></tr>
                                    <tr><th>Keterampilan</th><td>{{ $a->keterampilan }}</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Edit --}}
                <div class="modal fade" id="modalEdit{{ $a->id_alumni }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('admin.alumni.update', ['alumnus' => $a->id_alumni]) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title"><strong>Edit Alumni:</strong> {{ $a->nama }}</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body row">
                                    <div class="form-group col-md-6">
                                        <label>Nama</label>
                                        <input type="text" name="nama" class="form-control" value="{{ $a->nama }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>NIS</label>
                                        <input type="text" name="nis" class="form-control" value="{{ $a->nis }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>NISN</label>
                                        <input type="text" name="nisn" class="form-control" value="{{ $a->nisn }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" class="form-control" value="{{ $a->tempat_lahir }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ $a->tanggal_lahir }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Jenis Kelamin</label>
                                        <input type="text" name="jenis_kelamin" class="form-control" value="{{ $a->jenis_kelamin }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Alamat</label>
                                        <input type="text" name="alamat" class="form-control" value="{{ $a->alamat }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>No HP</label>
                                        <input type="text" name="no_hp" class="form-control" value="{{ $a->no_hp }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ $a->email }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Agama</label>
                                        <input type="text" name="agama" class="form-control" value="{{ $a->agama }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Sekolah SD</label>
                                        <input type="text" name="sekolah_sd" class="form-control" value="{{ $a->sekolah_sd }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Tahun Lulus SD</label>
                                        <input type="text" name="tahun_lulus_sd" class="form-control" value="{{ $a->tahun_lulus_sd }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Sekolah SMP</label>
                                        <input type="text" name="sekolah_smp" class="form-control" value="{{ $a->sekolah_smp }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Tahun Lulus SMP</label>
                                        <input type="text" name="tahun_lulus_smp" class="form-control" value="{{ $a->tahun_lulus_smp }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal Konfirmasi Hapus -->
                <div class="modal fade" id="modalHapus{{ $a->id_alumni }}" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel{{ $a->id_alumni }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="modalHapusLabel{{ $a->id_alumni }}">Konfirmasi Hapus</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                        Apakah Anda yakin ingin menghapus alumni <strong>{{ $a->nama }}</strong>?
                        </div>
                        <div class="modal-footer">
                        <form action="{{ route('admin.alumni.destroy', $a->id_alumni) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                        </form>
                        </div>
                    </div>
                    </div>
                </div>  
            @endforeach
        </div>
    </div>
</div>
<!-- Modal Tambah Alumni -->
<div class="modal fade" id="modalTambahAlumni" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.alumni.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Tambah Alumni</strong></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-12">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>NIS</label>
                        <input type="text" name="nis" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>NISN</label>
                        <input type="text" name="nisn" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Jurusan</label>
                        <select name="id_jurusan" class="form-control">
                            <option value="">-- Pilih Jurusan --</option>
                            @foreach($jurusan as $item)
                                <option value="{{ $item->id_jurusan }}">{{ $item->nama_jurusan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Alamat</label>
                        <input type="text" name="alamat" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>No HP</label>
                        <input type="text" name="no_hp" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Agama</label>
                        <input type="text" name="agama" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Sekolah SD</label>
                        <input type="text" name="sekolah_sd" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tahun Lulus SD</label>
                        <input type="text" name="tahun_lulus_sd" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Sekolah SMP</label>
                        <input type="text" name="sekolah_smp" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tahun Lulus SMP</label>
                        <input type="text" name="tahun_lulus_smp" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Sekolah SMK</label>
                        <input type="text" name="sekolah_smk" value="SMK Wisata Indonesia" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tahun Lulus</label>
                        <input type="text" name="tahun_lulus" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Pengalaman Kerja</label>
                        <input type="text" name="pengalaman_kerja" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Keterampilan</label>
                        <input type="text" name="keterampilan" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- <div class="modal fade" id="modalImport" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.data-alumni.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Data Alumni</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file">File Excel</label>
                        <input type="file" name="file" class="form-control" required>
                        <small class="text-muted">Format: .xlsx | <a href="{{ asset('template/template_alumni.xlsx') }}">Download Template</a></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Import</button>
                </div>
            </div>
        </form>
    </div> 
</div> --}}
@endsection

@push('scripts')
<!-- DataTables -->
<script>
    $(document).ready(function() {
        let jumlahData = {{ $alumni->count() }};
        if (jumlahData > 0) {
            $('#alumniTable').DataTable({
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "zeroRecords": "Tidak ditemukan dokumen",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ dokumen",
                    "infoEmpty": "Tidak ada data",
                    "infoFiltered": "(difilter dari _MAX_ total dokumen)",
                    "emptyTable": "Tidak ada data dokumen untuk ditampilkan"
                }
            });
        }
    });


@if (session('resetSuccess'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('resetSuccess') }}',
        timer: 3000,
        showConfirmButton: false
    });
@endif
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
