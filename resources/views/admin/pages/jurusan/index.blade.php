@extends('admin.layouts.app')
@section('title', 'Data Jurusan')

@section('content')
<div class="container">
    <h3 class="mb-4">Data Jurusan</h3>

    {{-- @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif --}}

    <!-- Tabel Jurusan -->
    <div class="card">
        <div class="d-flex justify-content-between align-items-center mb-2 card-header">
            <div>
                <h5 class="mb-0">Data Jurusan</h5>
            </div>
            <div>
                <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#tambahJurusanModal">
                    <i class="fas fa-plus"></i> Tambah
                </button>
                <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#modalImport">
                    <i class="fas fa-file-import"></i> Import
                </button>
            </div>
        </div>
        <div class="table-responsive px-3 pb-3 mt-2">
            <table class="table table-bordered" id="jurusanTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Singkatan Jurusan</th>
                        <th>Nama Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jurusan as $j)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $j->singkatan_jurusan }}</td>
                        <td>{{ $j->nama_jurusan }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $j->id_jurusan }}">
                                Edit
                            </button>
                            <form action="{{ route('admin.jurusan.destroy', $j->id_jurusan) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus jurusan ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal{{ $j->id_jurusan }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.jurusan.update', $j->id_jurusan) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header"><h5 class="modal-title">Edit Jurusan</h5></div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            <label>Singkatan</label>
                                            <input type="text" name="singkatan_jurusan" class="form-control" value="{{ $j->singkatan_jurusan }}" required>
                                        </div>
                                        <div>
                                            <label>Nama Jurusan</label>
                                            <input type="text" name="nama_jurusan" class="form-control" value="{{ $j->nama_jurusan }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahJurusanModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.jurusan.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Tambah Jurusan</h5></div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Singkatan</label>
                        <input type="text" name="singkatan_jurusan" class="form-control" required>
                    </div>
                    <div>
                        <label>Nama Jurusan</label>
                        <input type="text" name="nama_jurusan" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="modalImport" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.jurusan.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Import Data Jurusan</h5></div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="file">Pilih File Excel</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx, .xls" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let jumlahData = {{ $jurusan->count() }};
        if (jumlahData > 0) {
            $('#jurusanTable').DataTable({
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
