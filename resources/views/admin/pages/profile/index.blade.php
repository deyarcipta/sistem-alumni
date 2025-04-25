@extends('admin.layouts.app')
@section('title', 'Profile Admin')
@section('content')
<div class="container">
    <div class="row">
        <!-- Kolom Kiri -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ asset('storage/foto_admin/' . $profileAdmin->foto) }}" 
                        alt="Foto Admin" 
                        class="rounded-circle object-fit-cover" 
                        style="width: 150px; height: 150px;">
                    <h5 class="mt-3">{{ $profileAdmin->nama }}</h5>
                    <p>{{ $profileAdmin->role }}</p>
                    <form action="{{ route('admin.updateFoto', $profileAdmin->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input type="file" name="foto" class="form-control mt-2">
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Ubah Foto</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Profile</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.updateProfile', $profileAdmin->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" value="{{ old('nama', $profileAdmin->nama) }}" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Password Baru (opsional)</label>
                            <input type="password" name="password" class="form-control">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti password.</small>
                        </div>

                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
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
