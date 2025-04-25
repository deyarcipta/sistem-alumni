@extends('admin.layouts.app')
@section('title', 'Loker')
@section('content')
<div class="container">
    <h3 class="mb-4">Data Loker</h3>

    {{-- @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif --}}

    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            Daftar Loker
            <button class="btn btn-success" data-toggle="modal" data-target="#modalTambah">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </div>
        <div class="card-body table-responsive">
            <table id="lokerTable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Perusahaan</th>
                    <th>Judul</th>
                    <th>Foto</th>
                    <th>Deskripsi</th>
                    <th>Mulai</th>
                    <th>Berakhir</th>
                    <th>Lokasi</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($items as $i=>$item)
                  <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $item->perusahaan->nama_perusahaan }}</td>
                    <td>{{ $item->judul_loker }}</td>
                    <td>
                      @if($item->foto)
                        <a href="{{ Storage::url('loker/'.$item->foto) }}" target="_blank">Lihat Foto</a>
                      @else
                        <span class="text-muted">–</span>
                      @endif
                    </td>
                    <td>{{ Str::limit($item->deskripsi,50) }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d/m/Y') }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td>
                      <button class="btn btn-warning btn-sm"
                              data-toggle="modal"
                              data-target="#editModal{{ $item->id_loker }}">
                        <i class="fas fa-pencil-alt"></i>
                      </button>
                      <button class="btn btn-danger btn-sm"
                              data-toggle="modal"
                              data-target="#deleteModal{{ $item->id_loker }}">
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
    <form action="{{ route('admin.loker.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Loker</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="id_perusahaan">Perusahaan</label>
            <select name="id_perusahaan" id="id_perusahaan" class="form-control" required>
              @foreach(\App\Models\DaftarPerusahaan::all() as $p)
                <option value="{{ $p->id_perusahaan }}">{{ $p->nama_perusahaan }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="judul_loker">Judul Loker</label>
            <input type="text" name="judul_loker" id="judul_loker" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="foto">Foto (opsional)</label>
            <input type="file" name="foto" id="foto" class="form-control-file" accept="image/*">
          </div>
          <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="tanggal_mulai">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="tanggal_berakhir">Tanggal Berakhir</label>
            <input type="date" name="tanggal_berakhir" id="tanggal_berakhir" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="lokasi">Lokasi</label>
            <input type="text" name="lokasi" id="lokasi" class="form-control" required>
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
  <div class="modal fade" id="editModal{{ $item->id_loker }}" tabindex="-1">
    <div class="modal-dialog">
      <form action="{{ route('admin.loker.update', $item->id_loker) }}"
            method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Loker - {{ $item->judul_loker }}</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="id_perusahaan_{{ $item->id_loker }}">Perusahaan</label>
              <select name="id_perusahaan" id="id_perusahaan_{{ $item->id_loker }}" class="form-control" required>
                @foreach(\App\Models\DaftarPerusahaan::all() as $p)
                  <option value="{{ $p->id_perusahaan }}"
                    {{ $p->id_perusahaan==$item->id_perusahaan?'selected':'' }}>
                    {{ $p->nama_perusahaan }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="judul_loker_{{ $item->id_loker }}">Judul Loker</label>
              <input type="text" name="judul_loker" id="judul_loker_{{ $item->id_loker }}" class="form-control" value="{{ $item->judul_loker }}" required>
            </div>
            <div class="form-group">
              <label for="foto_{{ $item->id_loker }}">Ganti Foto</label>
              <input type="file" name="foto" id="foto_{{ $item->id_loker }}" class="form-control-file" accept="image/*">
            </div>
            <div class="form-group">
              <label for="deskripsi_{{ $item->id_loker }}">Deskripsi</label>
              <textarea name="deskripsi" id="deskripsi_{{ $item->id_loker }}" class="form-control" rows="3">{{ $item->deskripsi }}</textarea>
            </div>
            <div class="form-group">
              <label for="tanggal_mulai_{{ $item->id_loker }}">Tanggal Mulai</label>
              <input type="date" name="tanggal_mulai" id="tanggal_mulai_{{ $item->id_loker }}" class="form-control" value="{{ $item->tanggal_mulai }}" required>
            </div>
            <div class="form-group">
              <label for="tanggal_berakhir_{{ $item->id_loker }}">Tanggal Berakhir</label>
              <input type="date" name="tanggal_berakhir" id="tanggal_berakhir_{{ $item->id_loker }}" class="form-control" value="{{ $item->tanggal_berakhir }}" required>
            </div>
            <div class="form-group">
              <label for="lokasi_{{ $item->id_loker }}">Lokasi</label>
              <input type="text" name="lokasi" id="lokasi_{{ $item->id_loker }}" class="form-control" value="{{ $item->lokasi }}" required>
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
  <div class="modal fade" id="deleteModal{{ $item->id_loker }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Hapus Loker</h5>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          Hapus loker <strong>{{ $item->judul_loker }}</strong>?
        </div>
        <div class="modal-footer">
          <form action="{{ route('admin.loker.destroy', $item->id_loker) }}" method="POST">
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
    if ($('#lokerTable tbody tr').length) {
        $('#lokerTable').DataTable({
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
