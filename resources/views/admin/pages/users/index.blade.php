@extends('admin.layouts.app')
@section('title','User Management')
@section('content')
<div class="container">
    <h3 class="mb-4">Data User</h3>

    {{-- @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif --}}

    <div class="card mt-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span>Daftar User</span>
        <div>
          <button class="btn btn-secondary" data-toggle="modal" data-target="#modalImportUser">
            <i class="fas fa-file-import"></i> Import
          </button>
          <button class="btn btn-success" data-toggle="modal" data-target="#modalTambah">
            <i class="fas fa-plus"></i> Tambah
          </button>
        </div>
      </div>
      <div class="card-body table-responsive">
        <table id="usersTable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Role</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $i=>$u)
            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ $u->nama }}</td>
              <td>{{ $u->email }}</td>
              <td>{{ ucfirst(str_replace('_',' ',$u->role)) }}</td>
              <td>
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{ $u->id }}">
                  <i class="fas fa-edit"></i>
                </button>
                <form action="{{ route('admin.users.resetPassword',$u->id) }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-info btn-sm">
                    <i class="fas fa-key"></i>
                  </button>
                </form>
                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $u->id }}">
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
    <form action="{{ route('admin.users.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah User</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control" required>
              <option value="super_user">Admin</option>
              <option value="kepsek">Kepala Sekolah</option>
              <option value="tu">Tata Usaha</option>
              <option value="keuangan">Keuangan</option>
              <option value="bkk">BKK</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button class="btn btn-success">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- Modal Import --}}
<div class="modal fade" id="modalImportUser" tabindex="-1">
  <div class="modal-dialog">
      <div class="modal-content">
          <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-header">
                  <h5 class="modal-title">Import User</h5>
                  <a href="{{ asset('storage/template/template_import_user.xlsx') }}" class="btn btn-sm btn-success">
                      <i class="fas fa-download"></i> Download Template
                  </a>
              </div>
              <div class="modal-body">
                  <div class="form-group mb-3">
                      <label>Pilih File (.xls/.xlsx)</label>
                      <input type="file" name="file" class="form-control" accept=".csv, .xlsx" required>
                  </div>
                  <div class="alert alert-info mt-2">
                      <strong>Petunjuk:</strong><br>
                      Sebelum melakukan import file, pastikan file yang diimport menggunakan template yang sudah diunduh pada tombol di atas.
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Import</button>
              </div>
          </form>
      </div>
  </div>
</div>

@foreach($users as $u)
  {{-- Modal Edit --}}
  <div class="modal fade" id="editModal{{ $u->id }}" tabindex="-1">
    <div class="modal-dialog">
      <form action="{{ route('admin.users.update',$u->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit User</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Nama</label>
              <input type="text" name="nama" class="form-control" value="{{ $u->nama }}" required>
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email" class="form-control" value="{{ $u->email }}" required>
            </div>
            <div class="form-group">
              <label>Role</label>
              <select name="role" class="form-control" required>
                <option value="super_user" {{ $u->role==='super_user'?'selected':'' }}>Admin</option>
                <option value="kepsek"    {{ $u->role==='kepsek'?'selected':'' }}>Kepala Sekolah</option>
                <option value="tu"        {{ $u->role==='tu'?'selected':'' }}>Tata Usaha</option>
                <option value="keuangan"  {{ $u->role==='keuangan'?'selected':'' }}>Keuangan</option>
                <option value="bkk"       {{ $u->role==='bkk'?'selected':'' }}>BKK</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button class="btn btn-primary">Update</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- Modal Hapus --}}
  <div class="modal fade" id="deleteModal{{ $u->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Hapus User</h5>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          Hapus user <strong>{{ $u->name }}</strong>?
        </div>
        <div class="modal-footer">
          <form action="{{ route('admin.users.destroy',$u->id) }}" method="POST">
            @csrf @method('DELETE')
            <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button class="btn btn-danger">Hapus</button>
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
    $('#usersTable').DataTable({
      language:{
        search: "Cari:",
        lengthMenu: "Tampilkan _MENU_ data",
        zeroRecords: "Tidak ditemukan data",
        info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
        infoEmpty: "Tidak ada data",
        infoFiltered: "(difilter dari _MAX_ total)"
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
