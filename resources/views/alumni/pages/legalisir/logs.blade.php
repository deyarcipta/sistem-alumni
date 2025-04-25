@extends('alumni.layouts.app')
@section('title', 'Log Legalisir Alumni')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Log Pengajuan Legalisir</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Log Pengajuan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal Pengajuan</th>
                            <th>Alamat Pengajuan</th>
                            <th>Biaya Pengiriman</th>
                            <th>Status</th>
                            <th>Status Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($legalisirLogs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d-m-Y') }}</td>
                                <td>{{ $log->nama_jalan }}, RT/RW {{ $log->rt }}/{{ $log->rw }}, No. {{ $log->nomor_rumah }}, Kel. {{ ucwords(strtolower($log->kelurahan->nama)) }}, Kec. {{ ucwords(strtolower($log->kecamatan->nama)) }}, Kota {{ ucwords(strtolower($log->kota->nama)) }}, prov. {{ ucwords(strtolower($log->provinsi->nama)) }}</td>
                                <td>Rp {{ number_format($log->biaya_pengiriman ?? 0) }}</td>
                                <td>
                                    {{-- Badge Status Proses --}}
                                    @switch($log->status)
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
                                        <span class="badge badge-secondary">{{ ucfirst($log->status) }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    {{-- Badge Status Pembayaran --}}
                                    @switch($log->status_pembayaran)
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
                                        <span class="badge badge-secondary">{{ ucfirst($log->status_pembayaran) }}</span>
                                    @endswitch
                                </td>
                                <!-- Bagian Aksi -->
                                <td>
                                    <!-- Tombol Modal -->
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal{{ $log->id }}">
                                        Detail
                                    </button>

                                    @if($log->status == 'pending' && $log->biaya_pengiriman != null)
                                        <!-- Tombol Setujui -->
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#confirmApproveModal{{ $log->id }}">
                                            Setujui
                                        </button>
                                    @elseif($log->status == 'proses' && $log->status_pembayaran == 'belum bayar')
                                        <!-- Tombol Pembayaran -->
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#pembayaranModal{{ $log->id }}">
                                            Pembayaran
                                        </button>
                                    @endif
                                    <!-- Tombol Hapus -->
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $log->id }}">
                                        Hapus
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Detail -->
                            <div class="modal fade" id="detailModal{{ $log->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $log->id }}" aria-hidden="true">
                              <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="detailModalLabel{{ $log->id }}">Detail Pengajuan Legalisir</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <p><strong>Tanggal Pengajuan:</strong> {{ $log->created_at->format('d-m-Y H:i:s') }}</p>
                                    <p><strong>Email:</strong> {{ $log->email }}</p>
                                    <p><strong>Telepon:</strong> {{ $log->telepon }}</p>
                                    <p><strong>Alamat:</strong> {{ $log->nama_jalan }}, RT {{ $log->rt }}, RW {{ $log->rw }}
                                    <p><strong>Nomor Rumah:</strong> {{ $log->nomor_rumah }}</p>
                                    <p><strong>Kelurahan:</strong> {{ ucwords(strtolower($log->kelurahan->nama)) }}</p>
                                    <p><strong>Kecamatan:</strong> {{ ucwords(strtolower($log->kecamatan->nama)) }}</p>
                                    <p><strong>Kota:</strong> {{ ucwords(strtolower($log->kota->nama)) }}</p>
                                    <p><strong>Provinsi:</strong> {{ ucwords(strtolower($log->provinsi->nama)) }}</p>
                                    <p><strong>Kode Pos:</strong> {{ $log->kode_pos }}</p>
                                    <p><strong>Jasa Kirim:</strong> {{ strtoupper($log->jasa_kirim) }}</p>
                                    <p><strong>Biaya Pengiriman:</strong> Rp {{ number_format($log->biaya_pengiriman ?? 0) }}</p>
                                    <p><strong>Status:</strong> {{ ucfirst($log->status) }}</p>
                                    <p><strong>Nomor Resi:</strong> {{ $log->resi }}</p>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Modal Konfirmasi Persetujuan -->
                            <div class="modal fade" id="confirmApproveModal{{ $log->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmApproveModalLabel{{ $log->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="confirmApproveModalLabel{{ $log->id }}">Konfirmasi Persetujuan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                        Apakah Anda yakin ingin memproses legalisir ijazah ini?<br>
                                        <strong>Biaya Pengiriman:</strong> Rp {{ number_format($log->biaya_pengiriman ?? 0) }}
                                        </div>
                                        <div class="modal-footer">
                                        <form action="{{ route('alumni.legalisir.approve', $log->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Ya, Proses</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                                <!-- Modal Pembayaran -->
                                <div class="modal fade" id="pembayaranModal{{ $log->id }}" tabindex="-1" role="dialog" aria-labelledby="pembayaranModalLabel{{ $log->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="pembayaranModalLabel{{ $log->id }}">Informasi Pembayaran</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                        <p><strong>Silakan transfer ke rekening berikut:</strong></p>
                                        <ul>
                                            <li>Bank: {{ $setting->bank }}</li>
                                            <li>Nomor Rekening: <strong>{{ $setting->nomor_rekening }}</strong></li>
                                            <li>Atas Nama: <strong>{{ $setting->atas_nama }}</strong></li>
                                        </ul>
                                        <hr>
                                        <form action="{{ route('alumni.legalisir.uploadBukti', $log->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="bukti_pembayaran">Upload Bukti Pembayaran</label>
                                                <input type="file" name="bukti_pembayaran" class="form-control-file" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <!-- Modal Konfirmasi Hapus -->
                            <div class="modal fade" id="deleteModal{{ $log->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $log->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $log->id }}">Konfirmasi Hapus Pengajuan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus pengajuan ini?<br>
                                            <strong>Email:</strong> {{ $log->email }}<br>
                                            <strong>Alamat:</strong> {{ $log->nama_jalan }}, RT {{ $log->rt }}, RW {{ $log->rw }}<br>
                                            <strong>Status:</strong> {{ ucfirst($log->status) }}
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('alumni.legalisir.delete', $log->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let jumlahData = {{ $legalisirLogs->count() }};
        if (jumlahData > 0) {
            $('#dataTable').DataTable({
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "zeroRecords": "Tidak ditemukan dokumen",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ dokumen",
                    "infoEmpty": "Tidak ada data",
                    "infoFiltered": "(difilter dari _MAX_ total dokumen)",
                    "emptyTable": "Tidak ada data dokumen untuk ditampilkan"
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


