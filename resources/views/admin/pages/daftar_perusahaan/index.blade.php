@extends('admin.layouts.app')
@section('title', 'Daftar Perusahaan')
@section('content')
<div class="container">
    <h3 class="mb-4">Data Perusahaan</h3>

    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            Daftar Perusahaan
            <button class="btn btn-success" data-toggle="modal" data-target="#modalTambah">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </div>
        <div class="card-body table-responsive">
            <table id="perusahaanTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Website</th>
                        <th>Foto</th>
                        <th>Bidang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($items as $i => $item)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $item->nama_perusahaan }}</td>
                        <td>{{ Str::limit($item->alamat, 50) }}</td>
                        <td>{{ $item->telepon }}</td>
                        <td>
                            @if($item->website)
                                <a href="{{ $item->website }}" target="_blank">
                                    {{ Str::limit($item->website, 30) }}
                                </a>
                            @endif
                        </td>
                        <td>
                          @if($item->foto_perusahaan)
                              <a href="{{ Storage::url('daftar_perusahaan/'.$item->foto_perusahaan) }}"
                                 target="_blank">
                                  Lihat Foto
                              </a>
                          @else
                              <span class="text-muted">–</span>
                          @endif
                        </td>
                        <td>{{ $item->bidang_perusahaan }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm"
                                    data-toggle="modal"
                                    data-target="#editModal{{ $item->id_perusahaan }}">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="btn btn-danger btn-sm"
                                    data-toggle="modal"
                                    data-target="#deleteModal{{ $item->id_perusahaan }}">
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

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('admin.perusahaan.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Perusahaan</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          @foreach(['nama_perusahaan'=>'Nama','alamat'=>'Alamat','telepon'=>'Telepon','website'=>'Website','bidang_perusahaan'=>'Bidang'] as $field=>$label)
            <div class="form-group">
              <label for="{{ $field }}">{{ $label }}</label>
              @if($field==='alamat')
                <textarea name="{{ $field }}" id="{{ $field }}" class="form-control" rows="3" required></textarea>
              @else
                <input type="{{ $field==='website'?'url':'text' }}"
                       name="{{ $field }}"
                       id="{{ $field }}"
                       class="form-control"
                       {{ $field!=='website'?'required':'' }}>
              @endif
            </div>
          @endforeach
          <div class="form-group">
            <label for="foto_perusahaan">Foto Perusahaan</label>
            <input type="file"
                   name="foto_perusahaan"
                   id="foto_perusahaan"
                   class="form-control-file"
                   accept="image/*">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

@foreach($items as $item)
  {{-- Modal Edit --}}
  <div class="modal fade" id="editModal{{ $item->id_perusahaan }}" tabindex="-1">
    <div class="modal-dialog">
      <form action="{{ route('admin.perusahaan.update', $item->id_perusahaan) }}"
            method="POST"
            enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Perusahaan - {{ $item->nama_perusahaan }}</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            @foreach(['nama_perusahaan'=>'Nama','alamat'=>'Alamat','telepon'=>'Telepon','website'=>'Website','bidang_perusahaan'=>'Bidang'] as $field=>$label)
              <div class="form-group">
                <label for="{{ $field }}_{{ $item->id_perusahaan }}">{{ $label }}</label>
                @if($field==='alamat')
                  <textarea name="{{ $field }}"
                            id="{{ $field }}_{{ $item->id_perusahaan }}"
                            class="form-control"
                            rows="3"
                            required>{{ $item->$field }}</textarea>
                @else
                  <input type="{{ $field==='website'?'url':'text' }}"
                         name="{{ $field }}"
                         id="{{ $field }}_{{ $item->id_perusahaan }}"
                         class="form-control"
                         value="{{ $item->$field }}"
                         {{ $field!=='website'?'required':'' }}>
                @endif
              </div>
            @endforeach
            <div class="form-group">
              <label for="foto_perusahaan_{{ $item->id_perusahaan }}">Ganti Foto</label>
              <input type="file"
                     name="foto_perusahaan"
                     id="foto_perusahaan_{{ $item->id_perusahaan }}"
                     class="form-control-file"
                     accept="image/*">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- Modal Hapus --}}
  <div class="modal fade" id="deleteModal{{ $item->id_perusahaan }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Hapus Perusahaan</h5>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          Hapus perusahaan <strong>{{ $item->nama_perusahaan }}</strong>?
        </div>
        <div class="modal-footer">
          <form action="{{ route('admin.perusahaan.destroy', $item->id_perusahaan) }}"
                method="POST">
            @csrf @method('DELETE')
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
    if ($('#perusahaanTable tbody tr').length) {
        $('#perusahaanTable').DataTable({
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
