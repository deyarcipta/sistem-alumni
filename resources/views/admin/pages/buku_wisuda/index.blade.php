@extends('admin.layouts.app')
@section('title', 'Buku Wisuda')
@section('content')
<div class="container">
    <h3 class="mb-4">Data Buku Wisuda</h3>

    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            Daftar Buku Wisuda
            <button class="btn btn-success" data-toggle="modal" data-target="#modalTambahWisuda">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </div>
        <div class="card-body table-responsive">
            <table id="wisudaTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>File ZIP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($buku as $i => $w)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $w->tahun }}</td>
                        <td>{{ $w->judul }}</td>
                        <td>{{ Str::limit($w->deskripsi, 50) }}</td>
                        <td>
                            <a href="{{ Storage::url($w->file) }}" target="_blank">
                                lihat file
                            </a>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editWisudaModal{{ $w->id_buku_wisuda }}">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteWisudaModal{{ $w->id_buku_wisuda }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah Buku Wisuda --}}
<div class="modal fade" id="modalTambahWisuda" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('admin.bukuWisuda.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Buku Wisuda</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="tahun">Tahun</label>
            <input type="number" name="tahun" id="tahun" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" name="judul" id="judul" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="file">File ZIP</label>
            <input type="file" name="file" id="file" class="form-control-file" accept=".zip" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Upload</button>
        </div>
      </div>
    </form>
  </div>
</div>

@foreach($buku as $w)
  {{-- Modal Edit Buku Wisuda --}}
  <div class="modal fade" id="editWisudaModal{{ $w->id_buku_wisuda }}" tabindex="-1">
    <div class="modal-dialog">
      <form action="{{ route('admin.bukuWisuda.update', $w->id_buku_wisuda) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Buku Wisuda - {{ $w->tahun }}</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="tahun_{{ $w->id_buku_wisuda }}">Tahun</label>
              <input type="number" name="tahun" id="tahun_{{ $w->id_buku_wisuda }}" class="form-control" value="{{ $w->tahun }}" required>
            </div>
            <div class="form-group">
              <label for="judul_{{ $w->id_buku_wisuda }}">Judul</label>
              <input type="text" name="judul" id="judul_{{ $w->id_buku_wisuda }}" class="form-control" value="{{ $w->judul }}" required>
            </div>
            <div class="form-group">
              <label for="deskripsi_{{ $w->id_buku_wisuda }}">Deskripsi</label>
              <textarea name="deskripsi" id="deskripsi_{{ $w->id_buku_wisuda }}" class="form-control" rows="3">{{ $w->deskripsi }}</textarea>
            </div>
            <div class="form-group">
              <label for="file_{{ $w->id_buku_wisuda }}">Ganti File ZIP (opsional)</label>
              <input type="file" name="file" id="file_{{ $w->id_buku_wisuda }}" class="form-control-file" accept=".zip">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- Modal Hapus Buku Wisuda --}}
  <div class="modal fade" id="deleteWisudaModal{{ $w->id_buku_wisuda }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Hapus Buku Wisuda</h5>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          Hapus buku wisuda tahun <strong>{{ $w->tahun }}</strong> - <em>{{ $w->judul }}</em>?
        </div>
        <div class="modal-footer">
          <form action="{{ route('admin.bukuWisuda.destroy', $w->id_buku_wisuda) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Hapus</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endforeach
@endsection

@push('scripts')
<script>
$(function(){
    if ($('#wisudaTable tbody tr').length) {
        $('#wisudaTable').DataTable({
            language:{
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Tidak ditemukan data",
                info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                infoFiltered: "(difilter dari _MAX_ total)"
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
