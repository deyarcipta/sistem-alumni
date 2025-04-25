@extends('admin.layouts.app')
@section('title','Pengaturan Sistem Alumni')
@section('content')
<div class="container">
  <h3 class="mb-4">Pengaturan Sistem Alumni</h3>

  <div class="card">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="card-body">

        <div class="form-group">
          <label for="nama_sekolah">Nama Sekolah</label>
          <input type="text" name="nama_sekolah" id="nama_sekolah"
                 class="form-control"
                 value="{{ old('nama_sekolah',$setting->nama_sekolah) }}" required>
        </div>

        <div class="form-group">
          <label for="singkatan_sekolah">Singkatan Sekolah</label>
          <input type="text" name="singkatan_sekolah" id="singkatan_sekolah"
                 class="form-control"
                 value="{{ old('singkatan_sekolah',$setting->singkatan_sekolah) }}" required>
        </div>

        <div class="form-group">
          <label>Logo Sekolah</label><br>
          @if($setting->logo)
            <img src="{{ Storage::url('settings/'.$setting->logo) }}"
                 alt="Logo" style="max-height:100px;"><br><br>
          @endif
          <input type="file" name="logo" class="form-control-file" accept="image/*">
        </div>
        <div class="row">
          <div class="form-group col-md-4">
            <label for="no_wa_bkk">No. WA BKK</label>
            <input type="text" name="no_wa_bkk" id="no_wa_bkk"
                   class="form-control"
                   value="{{ old('no_wa_bkk',$setting->no_wa_bkk) }}">
          </div>
          <div class="form-group col-md-4">
            <label for="nama_bkk">Nama BKK</label>
            <input type="text" name="nama_bkk" id="nama_bkk"
                   class="form-control"
                   value="{{ old('nama_bkk',$setting->nama_bkk) }}">
          </div>
          <div class="form-group col-md-4">
            <label for="email_bkk">Email BKK</label>
            <input type="email" name="email_bkk" id="email_bkk"
                   class="form-control"
                   value="{{ old('email_bkk',$setting->email_bkk) }}">
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-4">
            <label for="bank">Bank</label>
            <input type="text" name="bank" id="bank"
                   class="form-control"
                   value="{{ old('bank', $setting->bank) }}">
          </div>
          
          <div class="form-group col-md-4">
            <label for="nomor_rekening">Nomor Rekening</label>
            <input type="text" name="nomor_rekening" id="nomor_rekening"
                   class="form-control"
                   value="{{ old('nomor_rekening', $setting->nomor_rekening) }}">
          </div>
          
          <div class="form-group col-md-4">
            <label for="atas_nama">Atas Nama Rekening</label>
            <input type="text" name="atas_nama" id="atas_nama"
                   class="form-control"
                   value="{{ old('atas_nama', $setting->atas_nama) }}">
          </div>
        </div>
        
        <div class="form-group">
          <label for="alamat_sekolah">Alamat Sekolah</label>
          <textarea name="alamat_sekolah" id="alamat_sekolah"
                    class="form-control"
                    rows="3">{{ old('alamat_sekolah',$setting->alamat_sekolah) }}</textarea>
        </div>

      </div>
      <div class="card-footer text-right">
        <button class="btn btn-primary">Simpan Pengaturan</button>
      </div>
    </form>
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