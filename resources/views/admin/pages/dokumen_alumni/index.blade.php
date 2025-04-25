@extends('admin.layouts.app')
@section('title', 'Data Semua Dokumen Alumni')

@section('content')
<div class="container">
    <h3 class="mb-4">Data Semua Dokumen Alumni</h3>
    {{-- @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif --}}
    <div class="card">
        <div class="d-flex justify-content-between align-items-center mb-2 card-header">
          <div>
              <h5 class="mb-0">Data Dokumen Alumni</h5>
          </div>
          <div>
              <button class="btn btn-success me-2" data-toggle="modal" data-target="#modalTambah">
                  <i class="fas fa-plus"></i> Tambah
              </button>
              <button class="btn btn-primary" data-toggle="modal" data-target="#modalImport">
                <i class="fas fa-file-import"></i> Import
            </button>
            <button class="btn btn-warning" data-toggle="modal" data-target="#modalUploadZip">
              <i class="fas fa-upload"></i> Upload Dokumen
            </button>
          </div>
      </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered" id="dokumenAlumniTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Alumni</th>
                        <th>Jenis Dokumen</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dokumenAlumni as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->alumni->nama ?? '-' }}</td>
                        <td>{{ $item->jenis_dokumen }}</td>
                        <td><a href="{{ asset('storage/dokumen/' . $item->file_path) }}" target="_blank">Lihat File</a></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalLihat{{ $item->id_dokumen }}">👁</button>
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit{{ $item->id_dokumen }}">✏️</button>
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapus{{ $item->id_dokumen }}">🗑</button>
                        </td>
                    </tr>

                    {{-- Modal Detail --}}
                    <div class="modal fade" id="modalLihat{{ $item->id_dokumen }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Dokumen</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Nama Alumni:</strong> {{ $item->alumni->nama }}</p>
                                    <p><strong>Jenis Dokumen:</strong> {{ $item->jenis_dokumen }}</p>
                                    <embed src="{{ asset('storage/dokumen/' . $item->file_path) }}" type="application/pdf" width="100%" height="400px"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Edit --}}
                    <div class="modal fade" id="modalEdit{{ $item->id_dokumen }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.dokumen.update', $item->id_dokumen) }}" method="POST" enctype="multipart/form-data">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Dokumen</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Jenis Dokumen</label>
                                            <input type="text" name="jenis_dokumen" class="form-control" value="{{ $item->jenis_dokumen }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Ganti File</label>
                                            <input type="file" name="file" class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Hapus --}}
                    <div class="modal fade" id="modalHapus{{ $item->id_dokumen }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.dokumen.destroy', $item->id_dokumen) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        Yakin ingin menghapus dokumen <strong>{{ $item->jenis_dokumen }}</strong> untuk alumni <strong>{{ $item->alumni->nama }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.dokumen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Dokumen</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Alumni</label>
                        <select name="id_alumni" class="form-control" required>
                            @foreach(\App\Models\Alumni::all() as $alumni)
                                <option value="{{ $alumni->id_alumni }}">{{ $alumni->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jenis Dokumen</label>
                        <input type="text" name="jenis_dokumen" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Upload File</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Modal Import Excel --}}
<div class="modal fade" id="modalImport" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.dokumen.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h5 class="modal-title">Import Data Dokumen</h5>
                    <a href="{{ asset('storage/template/template_import_dokumen.xlsx') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-download"></i> Download Template
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih File Excel</label>
                        <input type="file" name="file" class="form-control" required accept=".xlsx,.xls">
                    </div>
                    <div class="alert alert-info mt-2">
                        <strong>Petunjuk:</strong><br>
                        Sebelum melakukan import file, pastikan file yang diimport menggunakan template yang sudah diunduh pada tombol di atas.
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Modal Upload File Ijazah (ZIP) --}}
<div class="modal fade" id="modalUploadZip" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.dokumen.upload.zip') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Upload Ijazah (ZIP)</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Upload File ZIP</label>
                        <input type="file" name="zip_file" class="form-control" accept=".zip" required>
                        <small class="form-text text-muted">File harus dalam format .zip berisi dokumen alumni (.pdf) yang dinamai dengan ID alumni (contoh: <code>12345.pdf</code>).</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning">Upload & Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables -->
<script>
    $(document).ready(function() {
        let jumlahData = {{ $dokumenAlumni->count() }};
        if (jumlahData > 0) {
            $('#dokumenAlumniTable').DataTable({
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
