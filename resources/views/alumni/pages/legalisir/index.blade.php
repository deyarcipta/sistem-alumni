@extends('alumni.layouts.app')
@section('title', 'Legalisir Alumni')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Legalisir Ijazah</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('alumni.legalisir.store') }}" id="formLegalisir">
            @csrf

            <div class="form-group">
                <label>Nama Alumni</label>
                {{-- <input type="text" name="id_alumni" value="{{ $alumni->id_alumni }}" class="form-control" hidden> --}}
                <input type="text" value="{{ $alumni->nama }}" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label>NIS</label>
                <input type="text" value="{{ $alumni->nis }}" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input name="email" type="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label>No. Telepon</label>
                <input name="telepon" type="text" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Provinsi</label>
                <select name="provinsi_id" id="provinsi" class="form-control" required>
                    <option value="">-- Pilih Provinsi --</option>
                    @foreach ($provinsi as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Kota/Kabupaten</label>
                <select name="kota_id" id="kota" class="form-control" required></select>
            </div>

            <div class="form-group">
                <label>Kecamatan</label>
                <select name="kecamatan_id" id="kecamatan" class="form-control" required></select>
            </div>

            <div class="form-group">
                <label>Kelurahan</label>
                <select name="kelurahan_id" id="kelurahan" class="form-control" required></select>
            </div>

            <div id="detail-alamat" style="display: none;">
                <div class="form-group">
                    <label>Nama Jalan</label>
                    <input type="text" name="nama_jalan" class="form-control" required>
                </div>

                <div class="form-row">
                    <div class="col">
                        <label>RT</label>
                        <input type="text" name="rt" class="form-control">
                    </div>
                    <div class="col">
                        <label>RW</label>
                        <input type="text" name="rw" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label>Nomor Rumah</label>
                    <input type="text" name="nomor_rumah" class="form-control">
                </div>

                <div class="form-group">
                    <label>Kode Pos</label>
                    <input type="text" name="kode_pos" id="kode_pos" class="form-control" readonly>
                </div>
            </div>

            <div class="form-group">
                <label>Jasa Kirim</label>
                <select id="jasa_kirim" name="jasa_kirim" class="form-control">
                  <option value="">Pilih Jasa Kirim</option>
                  <option value="jne">JNE</option>
                  <option value="pos">POS</option>
              </select>
            </div>

            {{-- <div class="form-group">
                <label>Biaya Pengiriman (Rp)</label>
                <input type="text" id="biaya_pengiriman" name="biaya_pengiriman" class="form-control" readonly>
            </div> --}}

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#konfirmasiModal">
              Kirim Permohonan
          </button>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="konfirmasiModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Pengiriman</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Total biaya pengiriman akan diinformasikan oleh Admin SMK Wisata Indonesia melalui nomor WhatsApp yang Anda masukkan.<br>
        <strong>Pastikan nomor tersebut aktif dan memiliki WhatsApp.</strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" form="formLegalisir">Kirim Permohonan</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
$('#provinsi').on('change', function () {
    fetch('/api/kota/' + this.value)
        .then(res => res.json())
        .then(data => {
            $('#kota').html('<option value="">Pilih Kota</option>');
            data.forEach(d => $('#kota').append(`<option value="${d.id}">${d.nama}</option>`));
        });
});

$('#kota').on('change', function () {
    fetch('/api/kecamatan/' + this.value)
        .then(res => res.json())
        .then(data => {
            $('#kecamatan').html('<option value="">Pilih Kecamatan</option>');
            data.forEach(d => $('#kecamatan').append(`<option value="${d.id}">${d.nama}</option>`));
        });
});

$('#kecamatan').on('change', function () {
    fetch('/api/kelurahan/' + this.value)
        .then(res => res.json())
        .then(data => {
            $('#kelurahan').html('<option value="">Pilih Kelurahan</option>');
            data.forEach(d => $('#kelurahan').append(`<option value="${d.id}" data-kode="${d.kode_pos}">${d.nama}</option>`));
        });
});

$('#kelurahan').on('change', function () {
    let kode = $('#kelurahan option:selected').data('kode');
    $('#kode_pos').val(kode);
    $('#detail-alamat').show();
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
