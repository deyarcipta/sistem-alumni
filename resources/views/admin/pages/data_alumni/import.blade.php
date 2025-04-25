@extends('admin.layouts.app')
@section('title', 'Import Data Master Alumni')
@section('content')
<div class="container mt-4">
    <h4>Import Data Master</h4>

    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
          <h5 class="m-0 font-weight-bold text-primary">Import Data Alumni</h5>
          <a href="{{ asset('storage/template/template_import_alumni.xlsx') }}" class="btn btn-sm btn-success">
              <i class="fas fa-download"></i> Unduh Template
          </a>
      </div>
      <div class="card-body">
          <form action="{{ route('admin.data-alumni.import') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row align-items-end">
                  <div class="col-md-9 mb-3">
                      <label for="file" class="form-label">Upload File Excel</label>
                      <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>
                  </div>
                  <div class="col-md-3 mb-3">
                      <button type="submit" class="btn btn-primary w-100">
                          <i class="fas fa-file-import"></i> Import
                      </button>
                  </div>
              </div>
          </form>
  
          <hr>
  
          <p class="mb-1 text-muted"><i class="fas fa-info-circle"></i> Menu ini berfungsi untuk:</p>
          <h6 class="font-weight-bold">Import data alumni</h6>
          <p class="text-muted">Sebelum melakukan import file, pastikan file yang diimport menggunakan template yang sudah diunduh pada tombol di atas.</p>
      </div>
  </div>  
</div>
@endsection

@push('scripts')

<script>
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
