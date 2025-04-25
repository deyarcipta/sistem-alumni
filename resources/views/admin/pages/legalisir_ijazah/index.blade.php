@extends('admin.layouts.app')
@section('title', 'Legalisir Ijazah')
@section('content')
<div class="container">
    <h3 class="mb-4">Data Legalisir Ijazah</h3>

    {{-- @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif --}}

    <div class="card mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4 card-header">
            Daftar Legalisir Ijazah
        </div>
        <div class="card-body table-responsive">
            <table id="legalisirTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Alumni</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Jasa Kirim</th>
                        <th>Biaya</th>
                        <th>Status</th>
                        <th>Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data as $i => $d)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $d->alumni->nama }}</td>
                        <td>{{ $d->telepon }}</td>
                        <td>
                          {{ ucwords(strtolower($d->nama_jalan)) }},  
                          RT {{ $d->rt }}/RW {{ $d->rw }},<br>
                          {{ ucwords(strtolower(optional($d->kelurahan)->nama ?? '')) }},  
                          {{ ucwords(strtolower(optional($d->kecamatan)->nama ?? '')) }},<br>
                          {{ ucwords(strtolower(optional($d->kota)->nama ?? '')) }},  
                          {{ ucwords(strtolower(optional($d->provinsi)->nama ?? '')) }},  
                          {{ $d->kode_pos }}
                          
                        </td>
                        <td>{{ $d->jasa_kirim }}</td>
                        <td>Rp {{ number_format($d->biaya_pengiriman,0,',','.') }}</td>
                        <td>
                            {{-- Badge Status Proses --}}
                            @switch($d->status)
                            @case('pending')
                                <span class="badge badge-warning">Pending</span>
                                @break

                            @case('proses')
                                <span class="badge badge-primary">Proses</span>
                                @break

                            @case('dikirim')
                                <span class="badge badge-info">Dikirim</span>
                                @break

                            @case('selesai')
                                <span class="badge badge-success">Selesai</span>
                                @break

                            @default
                                <span class="badge badge-secondary">{{ ucfirst($d->status) }}</span>
                            @endswitch
                        </td>
                        <td>
                            {{-- Badge Status Pembayaran --}}
                            @switch($d->status_pembayaran)
                            @case('belum bayar')
                                <span class="badge badge-danger">Belum Bayar</span>
                                @break

                            @case('pengecekan')
                                <span class="badge badge-warning">Pengecekan</span>
                                @break

                            @case('sudah bayar')
                                <span class="badge badge-success">Sudah Bayar</span>
                                @break

                            @default
                                <span class="badge badge-secondary">{{ ucfirst($d->status_pembayaran) }}</span>
                            @endswitch
                        </td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewModal{{ $d->id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{ $d->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            {{-- Tombol Proses Bayar (hanya saat pengecekan) --}}
                            @if($d->status_pembayaran === 'pengecekan')
                              <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#prosesBayarModal{{ $d->id }}">
                                  <i class="fas fa-money-check-alt"></i>
                              </button>
                            @endif
                            {{-- Tombol Input Resi --}}
                            @if($d->status_pembayaran === 'sudah bayar' && !$d->resi)
                              <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#inputResiModal{{ $d->id }}">
                                  <i class="fas fa-truck-loading"></i>
                              </button>
                            @endif
                            {{-- Tombol Hapus --}}
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $d->id }}">
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

@foreach($data as $d)
    {{-- Modal View --}}
    <div class="modal fade" id="viewModal{{ $d->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Legalisir - {{ $d->alumni->nama }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless">
                        <tr><th>Email</th><td>{{ $d->email }}</td></tr>
                        <tr><th>Telepon</th><td>{{ $d->telepon }}</td></tr>
                        <tr>
                            <th>Alamat</th>
                            <td>
                              {{ ucwords(strtolower($d->nama_jalan)) }},  
                              RT {{ $d->rt }}/RW {{ $d->rw }},<br>
                              {{ ucwords(strtolower(optional($d->kelurahan)->nama ?? '')) }},  
                              {{ ucwords(strtolower(optional($d->kecamatan)->nama ?? '')) }},<br>
                              {{ ucwords(strtolower(optional($d->kota)->nama ?? '')) }},  
                              {{ ucwords(strtolower(optional($d->provinsi)->nama ?? '')) }},  
                              {{ $d->kode_pos }}
                              
                            </td>
                        </tr>
                        <tr><th>Jasa Kirim</th><td>{{ $d->jasa_kirim }}</td></tr>
                        <tr><th>Biaya</th><td>Rp {{ number_format($d->biaya_pengiriman,0,',','.') }}</td></tr>
                        <tr><th>Status</th><td>{{ ucfirst($d->status) }}</td></tr>
                        <tr><th>Status Bayar</th><td>{{ $d->status_pembayaran}}</td></tr>
                        @if($d->bukti_pembayaran)
                            <tr>
                                <th>Bukti Pembayaran</th>
                                <td><a href="{{ Storage::url($d->bukti_pembayaran) }}" target="_blank">Lihat Bukti</a></td>
                            </tr>
                        @endif
                        <tr><th>No. Resi</th><td>{{ $d->resi}}</td></tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit Biaya --}}
    <div class="modal fade" id="editModal{{ $d->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.legalisir.updateBiaya', $d->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Biaya - {{ $d->alumni->nama }}</h5>
                        <button class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="biaya_pengiriman_{{ $d->id }}">Biaya Pengiriman (Rp)</label>
                            <input id="biaya_pengiriman_{{ $d->id }}" type="number" name="biaya_pengiriman" class="form-control" value="{{ $d->biaya_pengiriman }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Modal Proses Bayar --}}
    <div class="modal fade" id="prosesBayarModal{{ $d->id }}" tabindex="-1">
      <div class="modal-dialog">
        <form action="{{ route('admin.legalisir.prosesBayar', $d->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Bukti Pembayaran - {{ $d->alumni->nama }}</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
              @if($d->bukti_pembayaran)
                {{-- Tampilkan gambar atau embed PDF sesuai tipe file --}}
                @php
                  $ext = pathinfo($d->bukti_pembayaran, PATHINFO_EXTENSION);
                  $url = Storage::url('bukti_pembayaran/'.$d->bukti_pembayaran);
                @endphp

                @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif']))
                  <img src="{{ $url }}" alt="Bukti Pembayaran" class="img-fluid">
                @elseif(strtolower($ext) === 'pdf')
                  <embed src="{{ $url }}" type="application/pdf" width="100%" height="400px" />
                @else
                  <a href="{{ $url }}" target="_blank">Download Bukti Pembayaran</a>
                @endif
              @else
                <p class="text-muted">Belum ada bukti pembayaran diunggah.</p>
              @endif
            </div>
            <div class="modal-footer">
              <button type="button"
                      class="btn btn-secondary"
                      data-dismiss="modal">
                Tutup
              </button>
              @if($d->bukti_pembayaran)
                <button type="submit"
                        name="status_pembayaran"
                        value="sudah bayar"
                        class="btn btn-success">
                  <i class="fas fa-check-circle"></i> Terima
                </button>
              @endif
            </div>
          </div>
        </form>
      </div>
    </div>

    {{-- Modal Input Resi --}}
    <div class="modal fade" id="inputResiModal{{ $d->id }}" tabindex="-1">
      <div class="modal-dialog">
        <form action="{{ route('admin.legalisir.inputResi', $d->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Input Nomor Resi - {{ $d->alumni->nama }}</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="resi_{{ $d->id }}">Nomor Resi</label>
                <input type="text"
                      id="resi_{{ $d->id }}"
                      name="resi"
                      class="form-control"
                      placeholder="Masukkan nomor resi"
                      required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button"
                      class="btn btn-secondary"
                      data-dismiss="modal">Tutup</button>
              <button type="submit"
                      class="btn btn-primary">Simpan Resi</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    {{-- Modal Hapus --}}
    <div class="modal fade" id="deleteModal{{ $d->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Hapus Legalisir</h5>
                    <button class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    Hapus permohonan legalisir milik <strong>{{ $d->alumni->nama }}</strong>?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.legalisir.destroy', $d->id) }}" method="POST">
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
    if ($('#legalisirTable tbody tr').length) {
        $('#legalisirTable').DataTable({
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
