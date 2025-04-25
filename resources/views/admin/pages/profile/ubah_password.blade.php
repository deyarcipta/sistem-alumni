@extends('admin.layouts.app')
@section('title', 'Ubah Password')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow rounded">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Ubah Password</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('alumni.profile.password.update') }}">
                        @csrf

                        <div class="form-group">
                            <label for="current_password">Password Lama</label>
                            <input type="password" name="current_password" class="form-control" id="current_password" required>
                        </div>

                        <div class="form-group">
                            <label for="new_password">Password Baru</label>
                            <input type="password" name="new_password" class="form-control" id="new_password" required>
                        </div>

                        <div class="form-group">
                            <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Ubah Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6',
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#d33',
        });
    @endif
</script>
@endpush
